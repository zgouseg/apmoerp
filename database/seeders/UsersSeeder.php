<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UsersSeeder - Seeds default users for the ERP system
 */
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainBranch = Branch::where('code', 'HQ')->first();
        $downtownBranch = Branch::where('code', 'BR1')->first();

        // Super Admin - Full system access
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@ghanem-erp.com'],
            [
                'name' => 'System Administrator',
                'name_ar' => 'مدير النظام',
                'email' => 'admin@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0001',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'en',
            ]
        );
        $superAdmin->assignRole('Super Admin');
        if ($mainBranch) {
            $superAdmin->branches()->syncWithoutDetaching([$mainBranch->id]);
            if ($downtownBranch) {
                $superAdmin->branches()->syncWithoutDetaching([$downtownBranch->id]);
            }
        }

        // Branch Admin
        $branchAdmin = User::updateOrCreate(
            ['email' => 'branch.admin@ghanem-erp.com'],
            [
                'name' => 'Branch Administrator',
                'name_ar' => 'مدير الفرع',
                'email' => 'branch.admin@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0002',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $branchAdmin->assignRole('Admin');
        if ($mainBranch) {
            $branchAdmin->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Manager
        $manager = User::updateOrCreate(
            ['email' => 'manager@ghanem-erp.com'],
            [
                'name' => 'Ahmed Hassan',
                'name_ar' => 'أحمد حسن',
                'email' => 'manager@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0003',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $manager->assignRole('Manager');
        if ($mainBranch) {
            $manager->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Accountant
        $accountant = User::updateOrCreate(
            ['email' => 'accountant@ghanem-erp.com'],
            [
                'name' => 'Sarah Mohamed',
                'name_ar' => 'سارة محمد',
                'email' => 'accountant@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0004',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $accountant->assignRole('Accountant');
        if ($mainBranch) {
            $accountant->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // HR Manager
        $hrManager = User::updateOrCreate(
            ['email' => 'hr@ghanem-erp.com'],
            [
                'name' => 'Fatima Ali',
                'name_ar' => 'فاطمة علي',
                'email' => 'hr@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0005',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $hrManager->assignRole('HR Manager');
        if ($mainBranch) {
            $hrManager->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Sales Manager
        $salesManager = User::updateOrCreate(
            ['email' => 'sales.manager@ghanem-erp.com'],
            [
                'name' => 'Omar Khaled',
                'name_ar' => 'عمر خالد',
                'email' => 'sales.manager@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0006',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $salesManager->assignRole('Sales Manager');
        if ($mainBranch) {
            $salesManager->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Salesperson
        $salesperson = User::updateOrCreate(
            ['email' => 'salesperson@ghanem-erp.com'],
            [
                'name' => 'Mohamed Ibrahim',
                'name_ar' => 'محمد إبراهيم',
                'email' => 'salesperson@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0007',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $salesperson->assignRole('Salesperson');
        if ($mainBranch) {
            $salesperson->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Warehouse Manager
        $warehouseManager = User::updateOrCreate(
            ['email' => 'warehouse.manager@ghanem-erp.com'],
            [
                'name' => 'Khaled Mahmoud',
                'name_ar' => 'خالد محمود',
                'email' => 'warehouse.manager@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0008',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $warehouseManager->assignRole('Warehouse Manager');
        if ($mainBranch) {
            $warehouseManager->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Warehouse Staff
        $warehouseStaff = User::updateOrCreate(
            ['email' => 'warehouse.staff@ghanem-erp.com'],
            [
                'name' => 'Ali Saeed',
                'name_ar' => 'علي سعيد',
                'email' => 'warehouse.staff@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0009',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $warehouseStaff->assignRole('Warehouse Staff');
        if ($mainBranch) {
            $warehouseStaff->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Cashier
        $cashier = User::updateOrCreate(
            ['email' => 'cashier@ghanem-erp.com'],
            [
                'name' => 'Nour Ahmed',
                'name_ar' => 'نور أحمد',
                'email' => 'cashier@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0010',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $cashier->assignRole('Cashier');
        if ($mainBranch) {
            $cashier->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Employee
        $employee = User::updateOrCreate(
            ['email' => 'employee@ghanem-erp.com'],
            [
                'name' => 'Hassan Youssef',
                'name_ar' => 'حسن يوسف',
                'email' => 'employee@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0011',
                'branch_id' => $mainBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $employee->assignRole('Employee');
        if ($mainBranch) {
            $employee->branches()->syncWithoutDetaching([$mainBranch->id]);
        }

        // Downtown Branch Staff
        $downtownCashier = User::updateOrCreate(
            ['email' => 'downtown.cashier@ghanem-erp.com'],
            [
                'name' => 'Mona Fathy',
                'name_ar' => 'منى فتحي',
                'email' => 'downtown.cashier@ghanem-erp.com',
                'password' => Hash::make('password'),
                'phone' => '+20 100 000 0012',
                'branch_id' => $downtownBranch?->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language' => 'ar',
            ]
        );
        $downtownCashier->assignRole('Cashier');
        if ($downtownBranch) {
            $downtownCashier->branches()->syncWithoutDetaching([$downtownBranch->id]);
        }
    }
}
