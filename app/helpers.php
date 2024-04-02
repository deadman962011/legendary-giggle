<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        return 1;
        // $settings = Cache::remember('business_settings', 86400, function () {
        //     return BusinessSetting::all();
        // });

        // if ($lang == false) {
        //     $setting = $settings->where('type', $key)->first();
        // } else {
        //     $setting = $settings->where('type', $key)->where('lang', $lang)->first();
        //     $setting = !$setting ? $settings->where('type', $key)->first() : $setting;
        // }
        // return $setting == null ? $default : $setting->value;
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
        // if (env('FILESYSTEM_DRIVER') == 's3') {
        //     return Storage::disk('s3')->url($path);
        // } else {
        //     // $base_path = @explode('/' , $path)[0];
        //     // if($base_path == 'storage')
        //     // {
        //     //     return app('url')->asset($path, $secure);
        //     // }
        // }
    }


if (! function_exists('generate_random_token')) {
    /**
     * Generate a random token.
     *
     * @param int $length
     * @return string
     */
    function generate_random_token($length = 32)
    {
        return Str::random($length);
    }
}




}
