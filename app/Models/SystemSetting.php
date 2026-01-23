<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    use HasFactory;

    protected $table = 'system_settings';

    /**
     * Generic key/value settings storage.
     *
     * - setting_key  : unique identifier (e.g. "app.name", "pos.receipt.footer")
     * - value        : json value
     * - type         : optional type hint (string,int,bool,array,json,encrypted,...)
     * - setting_group: logical group (e.g. "app","mail","pos","hr")
     * - is_public    : whether it can be exposed to clients without auth
     */
    protected $fillable = [
        'setting_key',
        'value',
        'type',
        'setting_group',
        'category',
        'is_public',
        'is_encrypted',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'value' => 'array',
        'is_public' => 'bool',
        'is_encrypted' => 'bool',
    ];

    /** Scopes */
    public function scopeSettingKey(Builder $query, string $settingKey): Builder
    {
        return $query->where('setting_key', $settingKey);
    }

    public function scopeSettingGroup(Builder $query, string $settingGroup): Builder
    {
        return $query->where('setting_group', $settingGroup);
    }

    /**
     * Get a setting value by setting_group and setting_key.
     *
     * @param  string|null  $settingGroup  The setting group (null for any group)
     * @param  string  $settingKey  The setting key
     * @param  mixed  $default  Default value if setting doesn't exist
     * @return mixed The setting value or default
     */
    public static function getValue(?string $settingGroup, string $settingKey, $default = null): mixed
    {
        $query = static::where('setting_key', $settingKey);

        if ($settingGroup !== null) {
            $query->where('setting_group', $settingGroup);
        }

        $setting = $query->first();

        if (! $setting) {
            return $default;
        }

        $value = $setting->value;
        $type = $setting->type ?? 'string';

        // For array/json types, preserve the full array
        if (in_array($type, ['array', 'json'], true)) {
            return is_array($value) ? $value : [$value];
        }

        // For non-array/json types, unwrap single-value arrays (legacy behavior)
        // If multiple values exist and type is non-array, return default for safety
        // (casting an array to bool/int/float would cause unexpected results)
        if (is_array($value)) {
            $value = count($value) === 1 ? $value[0] : $default;
        }

        // If value is still an array after unwrapping, return default
        // This handles the edge case where stored data doesn't match expected type
        if (is_array($value)) {
            return $default;
        }

        // Cast based on type
        return match ($type) {
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer', 'int' => is_numeric($value) ? (int) $value : $default,
            'float', 'decimal' => is_numeric($value) ? decimal_float($value) : $default,
            default => $value,
        };
    }

    /**
     * Get a setting value using cache.
     */
    public static function cachedValue(?string $settingGroup, string $settingKey, $default = null, int $ttlSeconds = 1800)
    {
        $cacheKey = sprintf('system_setting:%s:%s', $settingGroup ?? 'global', $settingKey);

        return Cache::remember($cacheKey, $ttlSeconds, function () use ($settingGroup, $settingKey, $default) {
            return static::getValue($settingGroup, $settingKey, $default);
        });
    }
}
