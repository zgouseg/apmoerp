<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\HrmCentral;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $per = min(max($request->integer('per_page', 20), 1), 100);
        $q = Attendance::query()->orderByDesc('logged_at');
        if ($request->filled('employee_id')) {
            $q->where('employee_id', $request->integer('employee_id'));
        }
        if ($request->filled('status')) {
            $q->where('status', $request->input('status'));
        }

        return $this->ok($q->paginate($per));
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Store a new attendance record
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'logged_at' => ['required', 'date'],
            'type' => ['required', 'string', 'in:check_in,check_out'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $attendance = Attendance::create([
            'employee_id' => $validated['employee_id'],
            'logged_at' => $validated['logged_at'],
            'type' => $validated['type'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            // V33-CRIT-02 FIX: Use actual_user_id() for proper audit attribution during impersonation
            'created_by' => actual_user_id(),
        ]);

        return $this->ok($attendance, __('Attendance record created'), 201);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Update an attendance record
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $this->validate($request, [
            'logged_at' => ['sometimes', 'date'],
            'type' => ['sometimes', 'string', 'in:check_in,check_out'],
            'notes' => ['nullable', 'string', 'max:500'],
            'status' => ['sometimes', 'string', 'in:pending,approved,rejected'],
        ]);

        $attendance->update($validated);

        return $this->ok($attendance, __('Attendance record updated'));
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Deactivate an attendance record
     */
    public function deactivate(Attendance $attendance)
    {
        $attendance->status = 'deactivated';
        $attendance->save();

        return $this->ok($attendance, __('Attendance record deactivated'));
    }

    public function approve(Attendance $record)
    {
        $record->status = 'approved';
        $record->approved_at = now();
        $record->save();

        return $this->ok($record, __('Approved'));
    }
}
