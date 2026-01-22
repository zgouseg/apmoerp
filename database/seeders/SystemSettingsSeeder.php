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
                'key' => 'company.name',
                'value' => 'Ghanem ERP',
                'type' => 'string',
                'group' => 'company',
                'is_public' => true,
            ],
            [
                'key' => 'company.name_ar',
                'value' => 'غانم ERP',
                'type' => 'string',
                'group' => 'company',
                'is_public' => true,
            ],
            [
                'key' => 'company.email',
                'value' => 'info@ghanem-erp.com',
                'type' => 'string',
                'group' => 'company',
                'is_public' => true,
            ],
            [
                'key' => 'company.phone',
                'value' => '+20 2 1234 5678',
                'type' => 'string',
                'group' => 'company',
                'is_public' => true,
            ],
            [
                'key' => 'company.address',
                'value' => '123 Business District, Cairo, Egypt',
                'type' => 'string',
                'group' => 'company',
                'is_public' => true,
            ],
            [
                'key' => 'company.tax_number',
                'value' => 'TAX-123456789',
                'type' => 'string',
                'group' => 'company',
                'is_public' => true,
            ],
            [
                'key' => 'company.commercial_registration',
                'value' => 'CR-123456',
                'type' => 'string',
                'group' => 'company',
                'is_public' => true,
            ],

            // System Settings
            [
                'key' => 'system.timezone',
                'value' => 'Africa/Cairo',
                'type' => 'string',
                'group' => 'system',
                'is_public' => false,
            ],
            [
                'key' => 'system.date_format',
                'value' => 'Y-m-d',
                'type' => 'string',
                'group' => 'system',
                'is_public' => false,
            ],
            [
                'key' => 'system.time_format',
                'value' => 'H:i:s',
                'type' => 'string',
                'group' => 'system',
                'is_public' => false,
            ],
            [
                'key' => 'system.default_language',
                'value' => 'ar',
                'type' => 'string',
                'group' => 'system',
                'is_public' => false,
            ],
            [
                'key' => 'system.pagination_size',
                'value' => '25',
                'type' => 'integer',
                'group' => 'system',
                'is_public' => false,
            ],

            // Currency Settings
            [
                'key' => 'currency.default',
                'value' => 'EGP',
                'type' => 'string',
                'group' => 'currency',
                'is_public' => false,
            ],
            [
                'key' => 'currency.decimal_places',
                'value' => '2',
                'type' => 'integer',
                'group' => 'currency',
                'is_public' => false,
            ],
            [
                'key' => 'currency.decimal_separator',
                'value' => '.',
                'type' => 'string',
                'group' => 'currency',
                'is_public' => false,
            ],
            [
                'key' => 'currency.thousand_separator',
                'value' => ',',
                'type' => 'string',
                'group' => 'currency',
                'is_public' => false,
            ],

            // Invoice Settings
            [
                'key' => 'invoice.prefix',
                'value' => 'INV-',
                'type' => 'string',
                'group' => 'invoice',
                'is_public' => false,
            ],
            [
                'key' => 'invoice.next_number',
                'value' => '1',
                'type' => 'integer',
                'group' => 'invoice',
                'is_public' => false,
            ],
            [
                'key' => 'invoice.default_due_days',
                'value' => '30',
                'type' => 'integer',
                'group' => 'invoice',
                'is_public' => false,
            ],
            [
                'key' => 'invoice.show_logo',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'invoice',
                'is_public' => false,
            ],

            // Purchase Order Settings
            [
                'key' => 'purchase.prefix',
                'value' => 'PO-',
                'type' => 'string',
                'group' => 'purchase',
                'is_public' => false,
            ],
            [
                'key' => 'purchase.next_number',
                'value' => '1',
                'type' => 'integer',
                'group' => 'purchase',
                'is_public' => false,
            ],
            [
                'key' => 'purchase.require_approval',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'purchase',
                'is_public' => false,
            ],
            [
                'key' => 'purchase.approval_threshold',
                'value' => '10000',
                'type' => 'decimal',
                'group' => 'purchase',
                'is_public' => false,
            ],

            // Inventory Settings
            [
                'key' => 'inventory.allow_negative_stock',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'inventory',
                'is_public' => false,
            ],
            [
                'key' => 'inventory.low_stock_threshold',
                'value' => '10',
                'type' => 'integer',
                'group' => 'inventory',
                'is_public' => false,
            ],
            [
                'key' => 'inventory.track_serial_numbers',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'inventory',
                'is_public' => false,
            ],
            [
                'key' => 'inventory.track_batches',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'inventory',
                'is_public' => false,
            ],

            // POS Settings
            [
                'key' => 'pos.allow_discount',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'pos',
                'is_public' => false,
            ],
            [
                'key' => 'pos.max_discount_percent',
                'value' => '20',
                'type' => 'integer',
                'group' => 'pos',
                'is_public' => false,
            ],
            [
                'key' => 'pos.require_customer',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'pos',
                'is_public' => false,
            ],
            [
                'key' => 'pos.print_receipt',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'pos',
                'is_public' => false,
            ],
            [
                'key' => 'pos.offline_mode_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'pos',
                'is_public' => false,
            ],

            // Tax Settings
            [
                'key' => 'tax.default_rate',
                'value' => '14',
                'type' => 'decimal',
                'group' => 'tax',
                'is_public' => false,
            ],
            [
                'key' => 'tax.inclusive',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'tax',
                'is_public' => false,
            ],

            // Notification Settings
            [
                'key' => 'notification.low_stock_email',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'is_public' => false,
            ],
            [
                'key' => 'notification.order_confirmation',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'is_public' => false,
            ],
            [
                'key' => 'notification.payment_received',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'is_public' => false,
            ],

            // Security Settings
            [
                'key' => 'security.session_timeout',
                'value' => '10080',
                'type' => 'integer',
                'group' => 'security',
                'is_public' => false,
            ],
            [
                'key' => 'security.two_factor_required',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'security',
                'is_public' => false,
            ],
            [
                'key' => 'security.password_min_length',
                'value' => '8',
                'type' => 'integer',
                'group' => 'security',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
