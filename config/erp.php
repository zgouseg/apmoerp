<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Discount Limits
    |--------------------------------------------------------------------------
    |
    | System-wide discount limits enforced by the EnforceDiscountLimit middleware.
    | Per-user overrides are read from User::max_line_discount / max_invoice_discount.
    | Users with 'discount.unlimited' or 'price.override' permissions bypass these.
    |
    */
    'discount' => [
        'max_line'    => (float) env('ERP_DISCOUNT_MAX_LINE', 15),
        'max_invoice' => (float) env('ERP_DISCOUNT_MAX_INVOICE', 20),
    ],

    /*
    |--------------------------------------------------------------------------
    | Barcode Settings
    |--------------------------------------------------------------------------
    |
    | Directory (relative to the storage disk) where generated barcode images
    | are stored.
    |
    */
    'barcodes' => [
        'dir' => env('ERP_BARCODES_DIR', 'barcodes'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Generated Code Prefixes
    |--------------------------------------------------------------------------
    |
    | Prefixes used when auto-generating reference codes for various entities.
    |
    */
    'prefixes' => [
        'customer'  => env('ERP_PREFIX_CUSTOMER', 'CUST-'),
        'supplier'  => env('ERP_PREFIX_SUPPLIER', 'SUP-'),
        'product'   => env('ERP_PREFIX_PRODUCT', 'PRD-'),
        'sale'      => env('ERP_PREFIX_SALE', 'INV-'),
        'purchase'  => env('ERP_PREFIX_PURCHASE', 'PO-'),
        'expense'   => env('ERP_PREFIX_EXPENSE', 'EXP-'),
        'income'    => env('ERP_PREFIX_INCOME', 'INC-'),
        'journal'   => env('ERP_PREFIX_JOURNAL', 'JE-'),
        'transfer'  => env('ERP_PREFIX_TRANSFER', 'TRF-'),
        'return'    => env('ERP_PREFIX_RETURN', 'RET-'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Default number of records per page in index / list views.
    |
    */
    'pagination' => [
        'default' => (int) env('ERP_PAGINATION_DEFAULT', 15),
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency & Precision
    |--------------------------------------------------------------------------
    |
    | Financial calculation precision and default currency.
    |
    */
    'currency' => [
        'default'  => env('ERP_DEFAULT_CURRENCY', 'EGP'),
        'decimals' => (int) env('ERP_CURRENCY_DECIMALS', 2),
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Defaults
    |--------------------------------------------------------------------------
    |
    | Defaults for Excel / CSV / PDF exports across the system.
    |
    */
    'export' => [
        'max_rows'   => (int) env('ERP_EXPORT_MAX_ROWS', 10000),
        'chunk_size' => (int) env('ERP_EXPORT_CHUNK_SIZE', 1000),
    ],
];
