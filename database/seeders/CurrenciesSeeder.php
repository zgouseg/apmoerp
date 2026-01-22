<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

/**
 * CurrenciesSeeder - Seeds common currencies
 */
class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'EGP',
                'name' => 'Egyptian Pound',
                'name_ar' => 'الجنيه المصري',
                'symbol' => 'ج.م',
                'decimal_places' => 2,
                'is_base' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'name_ar' => 'الدولار الأمريكي',
                'symbol' => '$',
                'decimal_places' => 2,
                'is_base' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'name_ar' => 'اليورو',
                'symbol' => '€',
                'decimal_places' => 2,
                'is_base' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'code' => 'SAR',
                'name' => 'Saudi Riyal',
                'name_ar' => 'الريال السعودي',
                'symbol' => 'ر.س',
                'decimal_places' => 2,
                'is_base' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'code' => 'AED',
                'name' => 'UAE Dirham',
                'name_ar' => 'الدرهم الإماراتي',
                'symbol' => 'د.إ',
                'decimal_places' => 2,
                'is_base' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound',
                'name_ar' => 'الجنيه الإسترليني',
                'symbol' => '£',
                'decimal_places' => 2,
                'is_base' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'code' => 'KWD',
                'name' => 'Kuwaiti Dinar',
                'name_ar' => 'الدينار الكويتي',
                'symbol' => 'د.ك',
                'decimal_places' => 3,
                'is_base' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($currencies as $currencyData) {
            Currency::updateOrCreate(
                ['code' => $currencyData['code']],
                $currencyData
            );
        }
    }
}
