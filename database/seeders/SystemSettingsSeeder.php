<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

/**
 * SystemSettingsSeeder - Seeds default system settings
 */
class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Company Information
            [
                'setting_key' => 'company.name',
                'value' => 'Ghanem ERP',
                'type' => 'string',
                'setting_group' => 'company',
                'is_public' => true,
            ],
            [
                'setting_key' => 'company.name_ar',
                'value' => 'غانم ERP',
                'type' => 'string',
                'setting_group' => 'company',
                'is_public' => true,
            ],
            [
                'setting_key' => 'company.email',
                'value' => 'info@ghanem-erp.com',
                'type' => 'string',
                'setting_group' => 'company',
                'is_public' => true,
            ],
            [
                'setting_key' => 'company.phone',
                'value' => '+20 2 1234 5678',
                'type' => 'string',
                'setting_group' => 'company',
                'is_public' => true,
            ],
            [
                'setting_key' => 'company.address',
                'value' => '123 Business District, Cairo, Egypt',
                'type' => 'string',
                'setting_group' => 'company',
                'is_public' => true,
            ],
            [
                'setting_key' => 'company.tax_number',
                'value' => 'TAX-123456789',
                'type' => 'string',
                'setting_group' => 'company',
                'is_public' => true,
            ],
            [
                'setting_key' => 'company.commercial_registration',
                'value' => 'CR-123456',
                'type' => 'string',
                'setting_group' => 'company',
                'is_public' => true,
            ],

            // System Settings
            [
                'setting_key' => 'system.timezone',
                'value' => 'Africa/Cairo',
                'type' => 'string',
                'setting_group' => 'system',
                'is_public' => false,
            ],
            [
                'setting_key' => 'system.date_format',
                'value' => 'Y-m-d',
                'type' => 'string',
                'setting_group' => 'system',
                'is_public' => false,
            ],
            [
                'setting_key' => 'system.time_format',
                'value' => 'H:i:s',
                'type' => 'string',
                'setting_group' => 'system',
                'is_public' => false,
            ],
            [
                'setting_key' => 'system.default_language',
                'value' => 'ar',
                'type' => 'string',
                'setting_group' => 'system',
                'is_public' => false,
            ],
            [
                'setting_key' => 'system.pagination_size',
                'value' => '25',
                'type' => 'integer',
                'setting_group' => 'system',
                'is_public' => false,
            ],

            // Currency Settings
            [
                'setting_key' => 'currency.default',
                'value' => 'EGP',
                'type' => 'string',
                'setting_group' => 'currency',
                'is_public' => false,
            ],
            [
                'setting_key' => 'currency.decimal_places',
                'value' => '2',
                'type' => 'integer',
                'setting_group' => 'currency',
                'is_public' => false,
            ],
            [
                'setting_key' => 'currency.decimal_separator',
                'value' => '.',
                'type' => 'string',
                'setting_group' => 'currency',
                'is_public' => false,
            ],
            [
                'setting_key' => 'currency.thousand_separator',
                'value' => ',',
                'type' => 'string',
                'setting_group' => 'currency',
                'is_public' => false,
            ],

            // Invoice Settings
            [
                'setting_key' => 'invoice.prefix',
                'value' => 'INV-',
                'type' => 'string',
                'setting_group' => 'invoice',
                'is_public' => false,
            ],
            [
                'setting_key' => 'invoice.next_number',
                'value' => '1',
                'type' => 'integer',
                'setting_group' => 'invoice',
                'is_public' => false,
            ],
            [
                'setting_key' => 'invoice.default_due_days',
                'value' => '30',
                'type' => 'integer',
                'setting_group' => 'invoice',
                'is_public' => false,
            ],
            [
                'setting_key' => 'invoice.show_logo',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'invoice',
                'is_public' => false,
            ],

            // Purchase Order Settings
            [
                'setting_key' => 'purchase.prefix',
                'value' => 'PO-',
                'type' => 'string',
                'setting_group' => 'purchase',
                'is_public' => false,
            ],
            [
                'setting_key' => 'purchase.next_number',
                'value' => '1',
                'type' => 'integer',
                'setting_group' => 'purchase',
                'is_public' => false,
            ],
            [
                'setting_key' => 'purchase.require_approval',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'purchase',
                'is_public' => false,
            ],
            [
                'setting_key' => 'purchase.approval_threshold',
                'value' => '10000',
                'type' => 'decimal',
                'setting_group' => 'purchase',
                'is_public' => false,
            ],

            // Inventory Settings
            [
                'setting_key' => 'inventory.allow_negative_stock',
                'value' => 'false',
                'type' => 'boolean',
                'setting_group' => 'inventory',
                'is_public' => false,
            ],
            [
                'setting_key' => 'inventory.low_stock_threshold',
                'value' => '10',
                'type' => 'integer',
                'setting_group' => 'inventory',
                'is_public' => false,
            ],
            [
                'setting_key' => 'inventory.track_serial_numbers',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'inventory',
                'is_public' => false,
            ],
            [
                'setting_key' => 'inventory.track_batches',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'inventory',
                'is_public' => false,
            ],

            // POS Settings
            [
                'setting_key' => 'pos.allow_discount',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'pos',
                'is_public' => false,
            ],
            [
                'setting_key' => 'pos.max_discount_percent',
                'value' => '20',
                'type' => 'integer',
                'setting_group' => 'pos',
                'is_public' => false,
            ],
            [
                'setting_key' => 'pos.require_customer',
                'value' => 'false',
                'type' => 'boolean',
                'setting_group' => 'pos',
                'is_public' => false,
            ],
            [
                'setting_key' => 'pos.print_receipt',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'pos',
                'is_public' => false,
            ],
            [
                'setting_key' => 'pos.offline_mode_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'pos',
                'is_public' => false,
            ],

            // Tax Settings
            [
                'setting_key' => 'tax.default_rate',
                'value' => '14',
                'type' => 'decimal',
                'setting_group' => 'tax',
                'is_public' => false,
            ],
            [
                'setting_key' => 'tax.inclusive',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'tax',
                'is_public' => false,
            ],

            // Notification Settings
            [
                'setting_key' => 'notification.low_stock_email',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'notification',
                'is_public' => false,
            ],
            [
                'setting_key' => 'notification.order_confirmation',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'notification',
                'is_public' => false,
            ],
            [
                'setting_key' => 'notification.payment_received',
                'value' => 'true',
                'type' => 'boolean',
                'setting_group' => 'notification',
                'is_public' => false,
            ],

            // Security Settings
            [
                'setting_key' => 'security.session_timeout',
                'value' => '10080',
                'type' => 'integer',
                'setting_group' => 'security',
                'is_public' => false,
            ],
            [
                'setting_key' => 'security.two_factor_required',
                'value' => 'false',
                'type' => 'boolean',
                'setting_group' => 'security',
                'is_public' => false,
            ],
            [
                'setting_key' => 'security.password_min_length',
                'value' => '8',
                'type' => 'integer',
                'setting_group' => 'security',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['setting_key' => $setting['setting_key']],
                $setting
            );
        }
    }
}
