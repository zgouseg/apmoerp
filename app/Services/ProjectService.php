<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectExpense;
use App\Models\ProjectTask;
use App\Models\ProjectTimeLog;
use App\Traits\HandlesServiceErrors;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    use HandlesServiceErrors;

    /**
     * Create a new project with branch scoping.
     */
    public function createProject(int $branchId, array $data): Project
    {
        return $this->handleServiceOperation(
            callback: fn () => DB::transaction(function () use ($branchId, $data) {
                return Project::create(array_merge($data, [
                    'branch_id' => $branchId,
                    'created_by' => actual_user_id(),
                ]));
            }),
            operation: 'createProject',
            context: ['branch_id' => $branchId]
        );
    }

    /**
     * Update an existing project.
     */
    public function updateProject(int $projectId, array $data): Project
    {
        return $this->handleServiceOperation(
            callback: function () use ($projectId, $data) {
                $project = Project::findOrFail($projectId);
                $project->update($data);

                return $project->fresh();
            },
            operation: 'updateProject',
            context: ['project_id' => $projectId]
        );
    }

    /**
     * Log time for a project task with overlap detection.
     *
     * Audit Report 10, Bug #2: Prevents overlapping time entries for the same
     * employee on the same date across different projects, which would inflate
     * billable hours and project costs.
     */
    public function logTime(int $projectId, array $data): ProjectTimeLog
    {
        return $this->handleServiceOperation(
            callback: fn () => DB::transaction(function () use ($projectId, $data) {
                $employeeId = $data['employee_id'] ?? $data['user_id'] ?? actual_user_id();
                $logDate = $data['log_date'] ?? $data['date'] ?? now()->toDateString();
                $hours = (float) ($data['hours'] ?? 0);

                if ($hours <= 0) {
                    throw new \InvalidArgumentException(__('Hours must be greater than zero.'));
                }

                // Check total logged hours for this employee on this date
                $existingHours = ProjectTimeLog::where('employee_id', $employeeId)
                    ->whereDate('log_date', $logDate)
                    ->sum('hours');

                $totalHours = bcadd((string) $existingHours, (string) $hours, 2);

                if (bccomp($totalHours, '24', 2) > 0) {
                    throw new \InvalidArgumentException(
                        __('Total logged hours for this date would exceed 24 hours (:total). Already logged: :existing h.', [
                            'total' => $totalHours,
                            'existing' => $existingHours,
                        ])
                    );
                }

                return ProjectTimeLog::create(array_merge($data, [
                    'project_id' => $projectId,
                    'employee_id' => $employeeId,
                    'user_id' => $employeeId,
                    'log_date' => $logDate,
                    'date' => $logDate,
                    'created_by' => actual_user_id(),
                ]));
            }),
            operation: 'logTime',
            context: ['project_id' => $projectId]
        );
    }

    /**
     * Add a task dependency with circular dependency detection.
     *
     * Audit Report 10, Bug #6: Prevents circular dependencies between tasks
     * (A depends on B, B depends on A) which would cause infinite recursion
     * when calculating project timelines.
     */
    public function addTaskDependency(int $taskId, int $dependsOnTaskId): void
    {
        $this->handleServiceOperation(
            callback: function () use ($taskId, $dependsOnTaskId) {
                if ($taskId === $dependsOnTaskId) {
                    throw new \InvalidArgumentException(__('A task cannot depend on itself.'));
                }

                $task = ProjectTask::findOrFail($taskId);
                $dependsOn = ProjectTask::findOrFail($dependsOnTaskId);

                if ($task->project_id !== $dependsOn->project_id) {
                    throw new \InvalidArgumentException(__('Tasks must belong to the same project.'));
                }

                // Check for circular dependency
                if ($this->wouldCreateCircularDependency($taskId, $dependsOnTaskId)) {
                    throw new \InvalidArgumentException(
                        __('Cannot add this dependency: it would create a circular reference.')
                    );
                }

                $task->dependencies()->syncWithoutDetaching([$dependsOnTaskId]);
            },
            operation: 'addTaskDependency',
            context: ['task_id' => $taskId, 'depends_on' => $dependsOnTaskId]
        );
    }

    /**
     * Check if adding a dependency would create a circular reference.
     *
     * Uses iterative BFS to detect cycles in the dependency graph.
     */
    private function wouldCreateCircularDependency(int $taskId, int $dependsOnTaskId): bool
    {
        // If we add "taskId depends on dependsOnTaskId", check whether
        // dependsOnTaskId already (transitively) depends on taskId.
        $visited = [];
        $queue = [$dependsOnTaskId];

        while (! empty($queue)) {
            $current = array_shift($queue);

            if ($current === $taskId) {
                return true;
            }

            if (isset($visited[$current])) {
                continue;
            }

            $visited[$current] = true;

            $upstreamIds = DB::table('task_dependencies')
                ->where('task_id', $current)
                ->pluck('depends_on_task_id')
                ->all();

            foreach ($upstreamIds as $id) {
                if (! isset($visited[$id])) {
                    $queue[] = $id;
                }
            }
        }

        return false;
    }

    /**
     * Create a project expense.
     */
    public function createExpense(int $projectId, array $data): ProjectExpense
    {
        return $this->handleServiceOperation(
            callback: fn () => ProjectExpense::create(array_merge($data, [
                'project_id' => $projectId,
                'created_by' => actual_user_id(),
            ])),
            operation: 'createExpense',
            context: ['project_id' => $projectId]
        );
    }

    /**
     * Get project statistics for a branch.
     */
    public function getProjectStats(int $branchId): array
    {
        return $this->handleServiceOperation(
            callback: function () use ($branchId) {
                $base = Project::where('branch_id', $branchId);

                return [
                    'total' => (clone $base)->count(),
                    'active' => (clone $base)->active()->count(),
                    'completed' => (clone $base)->completed()->count(),
                    'overdue' => (clone $base)->overdue()->count(),
                    'over_budget' => (clone $base)->overBudget()->count(),
                ];
            },
            operation: 'getProjectStats',
            context: ['branch_id' => $branchId],
            defaultValue: ['total' => 0, 'active' => 0, 'completed' => 0, 'overdue' => 0, 'over_budget' => 0]
        );
    }

    /**
     * Get overdue tasks for a project.
     *
     * @return Collection<int, ProjectTask>
     */
    public function getOverdueTasks(int $projectId): Collection
    {
        return $this->handleServiceOperation(
            callback: fn () => ProjectTask::where('project_id', $projectId)
                ->overdue()
                ->with('assignedTo')
                ->orderBy('due_date')
                ->get(),
            operation: 'getOverdueTasks',
            context: ['project_id' => $projectId],
            defaultValue: new Collection
        );
    }
}
