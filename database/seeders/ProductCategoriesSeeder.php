<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

/**
 * ProductCategoriesSeeder - Seeds default product categories
 */
class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainBranch = Branch::where('code', 'HQ')->first();
        $branchId = $mainBranch?->id;

        $categories = [
            [
                'name' => 'Electronics',
                'name_ar' => 'إلكترونيات',
                'slug' => 'electronics',
                'description' => 'Electronic devices and accessories',
                'is_active' => true,
                'sort_order' => 1,
                'children' => [
                    [
                        'name' => 'Computers',
                        'name_ar' => 'أجهزة كمبيوتر',
                        'slug' => 'computers',
                        'is_active' => true,
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Mobile Phones',
                        'name_ar' => 'هواتف محمولة',
                        'slug' => 'mobile-phones',
                        'is_active' => true,
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Accessories',
                        'name_ar' => 'إكسسوارات',
                        'slug' => 'electronic-accessories',
                        'is_active' => true,
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'Automotive Parts',
                'name_ar' => 'قطع غيار سيارات',
                'slug' => 'automotive-parts',
                'description' => 'Automotive spare parts and accessories',
                'is_active' => true,
                'sort_order' => 2,
                'children' => [
                    [
                        'name' => 'Engine Parts',
                        'name_ar' => 'قطع المحرك',
                        'slug' => 'engine-parts',
                        'is_active' => true,
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Brakes',
                        'name_ar' => 'الفرامل',
                        'slug' => 'brakes',
                        'is_active' => true,
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Suspension',
                        'name_ar' => 'نظام التعليق',
                        'slug' => 'suspension',
                        'is_active' => true,
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Electrical Parts',
                        'name_ar' => 'القطع الكهربائية',
                        'slug' => 'electrical-parts',
                        'is_active' => true,
                        'sort_order' => 4,
                    ],
                    [
                        'name' => 'Body Parts',
                        'name_ar' => 'قطع الهيكل',
                        'slug' => 'body-parts',
                        'is_active' => true,
                        'sort_order' => 5,
                    ],
                ],
            ],
            [
                'name' => 'Office Supplies',
                'name_ar' => 'مستلزمات مكتبية',
                'slug' => 'office-supplies',
                'description' => 'Office equipment and stationery',
                'is_active' => true,
                'sort_order' => 3,
                'children' => [
                    [
                        'name' => 'Stationery',
                        'name_ar' => 'قرطاسية',
                        'slug' => 'stationery',
                        'is_active' => true,
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Furniture',
                        'name_ar' => 'أثاث',
                        'slug' => 'office-furniture',
                        'is_active' => true,
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'Raw Materials',
                'name_ar' => 'مواد خام',
                'slug' => 'raw-materials',
                'description' => 'Raw materials for manufacturing',
                'is_active' => true,
                'sort_order' => 4,
                'children' => [
                    [
                        'name' => 'Wood',
                        'name_ar' => 'خشب',
                        'slug' => 'wood',
                        'is_active' => true,
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Metal',
                        'name_ar' => 'معدن',
                        'slug' => 'metal',
                        'is_active' => true,
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Plastic',
                        'name_ar' => 'بلاستيك',
                        'slug' => 'plastic',
                        'is_active' => true,
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'Finished Goods',
                'name_ar' => 'منتجات جاهزة',
                'slug' => 'finished-goods',
                'description' => 'Completed manufactured products',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Consumables',
                'name_ar' => 'مستهلكات',
                'slug' => 'consumables',
                'description' => 'Consumable items and supplies',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Services',
                'name_ar' => 'خدمات',
                'slug' => 'services',
                'description' => 'Non-physical service items',
                'is_active' => true,
                'sort_order' => 7,
                'children' => [
                    [
                        'name' => 'Installation',
                        'name_ar' => 'تركيب',
                        'slug' => 'installation',
                        'is_active' => true,
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Maintenance',
                        'name_ar' => 'صيانة',
                        'slug' => 'maintenance',
                        'is_active' => true,
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Consulting',
                        'name_ar' => 'استشارات',
                        'slug' => 'consulting',
                        'is_active' => true,
                        'sort_order' => 3,
                    ],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            if ($branchId) {
                $categoryData['branch_id'] = $branchId;
            }

            $parent = ProductCategory::updateOrCreate(
                ['slug' => $categoryData['slug'], 'branch_id' => $branchId],
                $categoryData
            );

            foreach ($children as $childData) {
                if ($branchId) {
                    $childData['branch_id'] = $branchId;
                }
                $childData['parent_id'] = $parent->id;

                ProductCategory::updateOrCreate(
                    ['slug' => $childData['slug'], 'branch_id' => $branchId],
                    $childData
                );
            }
        }
    }
}
