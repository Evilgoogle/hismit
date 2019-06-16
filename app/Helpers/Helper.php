<?php
/*
  |--------------------------------------------------------------------------
  | Libs
  |--------------------------------------------------------------------------
*/

if (!function_exists('getBlock')) {

    function getBlock($key) {
        return \App\Block::where('key', $key)->where('enable', true)->pluck('desc')->first();
    }
}

if (!function_exists('configKey')) {
    function configKey($key) {
        return App\Config::where('key', $key)->pluck('value')->first();
    }
}
