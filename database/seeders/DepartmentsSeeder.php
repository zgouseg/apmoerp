<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * DepartmentsSeeder - Seeds departments and cost centers for the new tables
 */
class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainBranch = Branch::where('code', 'HQ')->first();
        $branchId = $mainBranch?->id;

        if (! $branchId) {
            return;
        }

        // Seed departments
        $departments = [
            [
                'branch_id' => $branchId,
                'name' => 'Administration',
                'name_ar' => 'الإدارة',
                'code' => 'ADMIN',
                'description' => 'General administration and management',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Sales',
                'name_ar' => 'المبيعات',
                'code' => 'SALES',
                'description' => 'Sales and customer relations',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Purchasing',
                'name_ar' => 'المشتريات',
                'code' => 'PURCH',
                'description' => 'Procurement and supplier management',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Warehouse',
                'name_ar' => 'المستودع',
                'code' => 'WH',
                'description' => 'Inventory and warehouse operations',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Finance',
                'name_ar' => 'المالية',
                'code' => 'FIN',
                'description' => 'Accounting and financial operations',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Human Resources',
                'name_ar' => 'الموارد البشرية',
                'code' => 'HR',
                'description' => 'HR and employee management',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'IT',
                'name_ar' => 'تقنية المعلومات',
                'code' => 'IT',
                'description' => 'Information technology and systems',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Production',
                'name_ar' => 'الإنتاج',
                'code' => 'PROD',
                'description' => 'Manufacturing and production',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Quality Control',
                'name_ar' => 'مراقبة الجودة',
                'code' => 'QC',
                'description' => 'Quality assurance and control',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Customer Service',
                'name_ar' => 'خدمة العملاء',
                'code' => 'CS',
                'description' => 'Customer support and service',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($departments as $dept) {
            DB::table('departments')->updateOrInsert(
                ['branch_id' => $dept['branch_id'], 'code' => $dept['code']],
                array_merge($dept, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // Get department IDs for cost centers
        $deptIds = DB::table('departments')
            ->where('branch_id', $branchId)
            ->pluck('id', 'code')
            ->toArray();

        // Seed cost centers
        $costCenters = [
            [
                'branch_id' => $branchId,
                'name' => 'General Operations',
                'name_ar' => 'العمليات العامة',
                'code' => 'CC-OPS',
                'description' => 'General operational expenses',
                'department_id' => $deptIds['ADMIN'] ?? null,
                'budget' => 500000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Sales & Marketing',
                'name_ar' => 'المبيعات والتسويق',
                'code' => 'CC-SALES',
                'description' => 'Sales and marketing expenses',
                'department_id' => $deptIds['SALES'] ?? null,
                'budget' => 300000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Procurement',
                'name_ar' => 'المشتريات',
                'code' => 'CC-PROC',
                'description' => 'Procurement and purchasing expenses',
                'department_id' => $deptIds['PURCH'] ?? null,
                'budget' => 1000000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Warehouse Operations',
                'name_ar' => 'عمليات المستودع',
                'code' => 'CC-WH',
                'description' => 'Warehouse and logistics expenses',
                'department_id' => $deptIds['WH'] ?? null,
                'budget' => 200000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'HR & Payroll',
                'name_ar' => 'الموارد البشرية والرواتب',
                'code' => 'CC-HR',
                'description' => 'Human resources and payroll expenses',
                'department_id' => $deptIds['HR'] ?? null,
                'budget' => 1500000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'IT & Technology',
                'name_ar' => 'تقنية المعلومات',
                'code' => 'CC-IT',
                'description' => 'IT infrastructure and software expenses',
                'department_id' => $deptIds['IT'] ?? null,
                'budget' => 250000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Production',
                'name_ar' => 'الإنتاج',
                'code' => 'CC-PROD',
                'description' => 'Manufacturing and production expenses',
                'department_id' => $deptIds['PROD'] ?? null,
                'budget' => 800000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Quality Assurance',
                'name_ar' => 'ضمان الجودة',
                'code' => 'CC-QA',
                'description' => 'Quality control and testing expenses',
                'department_id' => $deptIds['QC'] ?? null,
                'budget' => 100000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Customer Support',
                'name_ar' => 'دعم العملاء',
                'code' => 'CC-SUPPORT',
                'description' => 'Customer service and support expenses',
                'department_id' => $deptIds['CS'] ?? null,
                'budget' => 150000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'branch_id' => $branchId,
                'name' => 'Maintenance',
                'name_ar' => 'الصيانة',
                'code' => 'CC-MAINT',
                'description' => 'Facility and equipment maintenance',
                'department_id' => null,
                'budget' => 100000.0000,
                'budget_period' => 'yearly',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($costCenters as $cc) {
            DB::table('cost_centers')->updateOrInsert(
                ['branch_id' => $cc['branch_id'], 'code' => $cc['code']],
                array_merge($cc, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
