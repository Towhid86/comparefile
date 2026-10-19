<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (! function_exists('get_option')) {
    function get_option(string $key, mixed $default = []): mixed
    {
        try {
            return Cache::remember($key, 3600, function () use ($key, $default) {
                if (! Schema::hasTable('options')) {
                    return $default;
                }

                $option = DB::table('options')->where('key', $key)->first();

                if (! $option) {
                    return $default;
                }

                $value = $option->value;
                $decoded = is_string($value) ? json_decode($value, true) : null;

                return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
            });
        } catch (Throwable) {
            return $default;
        }
    }
}
