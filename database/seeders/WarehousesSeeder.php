<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

/**
 * WarehousesSeeder - Seeds default warehouses
 */
class WarehousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainBranch = Branch::where('code', 'HQ')->first();
        $downtownBranch = Branch::where('code', 'BR1')->first();

        if ($mainBranch) {
            // Main branch warehouses
            Warehouse::updateOrCreate(
                ['branch_id' => $mainBranch->id, 'code' => 'WH-MAIN'],
                [
                    'name' => 'Main Warehouse',
                    'name_ar' => 'المستودع الرئيسي',
                    'code' => 'WH-MAIN',
                    'address' => '123 Industrial Zone, City Center',
                    'phone' => '+20 2 1234 5680',
                    'type' => 'standard',
                    'is_active' => true,
                    'is_default' => true,
                    'allow_negative_stock' => false,
                ]
            );

            Warehouse::updateOrCreate(
                ['branch_id' => $mainBranch->id, 'code' => 'WH-RETAIL'],
                [
                    'name' => 'Retail Store',
                    'name_ar' => 'مخزن البيع',
                    'code' => 'WH-RETAIL',
                    'address' => '123 Business District, City Center',
                    'phone' => '+20 2 1234 5681',
                    'type' => 'standard',
                    'is_active' => true,
                    'is_default' => false,
                    'allow_negative_stock' => false,
                ]
            );

            Warehouse::updateOrCreate(
                ['branch_id' => $mainBranch->id, 'code' => 'WH-DAMAGED'],
                [
                    'name' => 'Damaged Goods',
                    'name_ar' => 'البضائع التالفة',
                    'code' => 'WH-DAMAGED',
                    'address' => '123 Industrial Zone, City Center',
                    'phone' => '+20 2 1234 5682',
                    'type' => 'virtual',
                    'is_active' => true,
                    'is_default' => false,
                    'allow_negative_stock' => true,
                ]
            );

            Warehouse::updateOrCreate(
                ['branch_id' => $mainBranch->id, 'code' => 'WH-TRANSIT'],
                [
                    'name' => 'In Transit',
                    'name_ar' => 'في الطريق',
                    'code' => 'WH-TRANSIT',
                    'address' => 'Virtual Location',
                    'phone' => null,
                    'type' => 'transit',
                    'is_active' => true,
                    'is_default' => false,
                    'allow_negative_stock' => true,
                ]
            );
        }

        if ($downtownBranch) {
            // Downtown branch warehouse
            Warehouse::updateOrCreate(
                ['branch_id' => $downtownBranch->id, 'code' => 'WH-DT'],
                [
                    'name' => 'Downtown Store',
                    'name_ar' => 'مخزن وسط البلد',
                    'code' => 'WH-DT',
                    'address' => '45 Downtown Street',
                    'phone' => '+20 2 9876 5432',
                    'type' => 'standard',
                    'is_active' => true,
                    'is_default' => true,
                    'allow_negative_stock' => false,
                ]
            );
        }
    }
}
