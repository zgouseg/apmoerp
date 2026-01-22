<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Tax;
use Illuminate\Database\Seeder;

/**
 * TaxesSeeder - Seeds common tax rates
 */
class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainBranch = Branch::where('code', 'HQ')->first();
        $branchId = $mainBranch?->id;

        $taxes = [
            [
                'name' => 'VAT 14%',
                'name_ar' => 'ضريبة القيمة المضافة 14%',
                'code' => 'VAT14',
                'rate' => 14.0000,
                'type' => 'percentage',
                'is_compound' => false,
                'is_inclusive' => false,
                'is_active' => true,
                'description' => 'Standard VAT rate in Egypt',
            ],
            [
                'name' => 'VAT 0% (Exempt)',
                'name_ar' => 'ضريبة القيمة المضافة 0% (معفى)',
                'code' => 'VAT0',
                'rate' => 0.0000,
                'type' => 'percentage',
                'is_compound' => false,
                'is_inclusive' => false,
                'is_active' => true,
                'description' => 'Tax exempt items',
            ],
            [
                'name' => 'Table Tax 5%',
                'name_ar' => 'ضريبة الجدول 5%',
                'code' => 'TBL5',
                'rate' => 5.0000,
                'type' => 'percentage',
                'is_compound' => true,
                'is_inclusive' => false,
                'is_active' => true,
                'description' => 'Table tax for specific goods',
            ],
            [
                'name' => 'Table Tax 10%',
                'name_ar' => 'ضريبة الجدول 10%',
                'code' => 'TBL10',
                'rate' => 10.0000,
                'type' => 'percentage',
                'is_compound' => true,
                'is_inclusive' => false,
                'is_active' => true,
                'description' => 'Table tax for luxury goods',
            ],
            [
                'name' => 'Withholding Tax 1%',
                'name_ar' => 'ضريبة الخصم 1%',
                'code' => 'WHT1',
                'rate' => 1.0000,
                'type' => 'percentage',
                'is_compound' => false,
                'is_inclusive' => false,
                'is_active' => true,
                'description' => 'Withholding tax on supplier payments',
            ],
            [
                'name' => 'Withholding Tax 3%',
                'name_ar' => 'ضريبة الخصم 3%',
                'code' => 'WHT3',
                'rate' => 3.0000,
                'type' => 'percentage',
                'is_compound' => false,
                'is_inclusive' => false,
                'is_active' => true,
                'description' => 'Withholding tax on professional services',
            ],
            [
                'name' => 'No Tax',
                'name_ar' => 'بدون ضريبة',
                'code' => 'NOTAX',
                'rate' => 0.0000,
                'type' => 'percentage',
                'is_compound' => false,
                'is_inclusive' => false,
                'is_active' => true,
                'description' => 'No tax applicable',
            ],
        ];

        foreach ($taxes as $taxData) {
            if ($branchId) {
                $taxData['branch_id'] = $branchId;
            }
            Tax::updateOrCreate(
                ['code' => $taxData['code'], 'branch_id' => $branchId],
                $taxData
            );
        }
    }
}
