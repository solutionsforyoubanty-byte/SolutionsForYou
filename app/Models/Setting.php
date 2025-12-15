<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        return Cache::remember('setting_' . $key, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value)
    {
        Cache::forget('setting_' . $key);
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function isCodEnabled()
    {
        return self::get('cod_enabled', '1') === '1';
    }

    public static function getCodMinOrder()
    {
        return (float) self::get('cod_min_order', '0');
    }

    public static function getCodMaxOrder()
    {
        $max = self::get('cod_max_order', '0');
        return $max ? (float) $max : null;
    }
}
