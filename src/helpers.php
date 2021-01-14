<?php

use Illuminate\Support\Facades\Schema;

if (!function_exists('settings'))
{
    /**
     * @param null $key
     * @param null $default
     *
     * @return string|null
     */
    function settings($key = null)
    {
        if (Schema::hasTable('settings'))
        {
            $settingValue = \Illuminate\Support\Facades\DB::table('settings')
                ->where('key', $key)
                ->pluck('value')
                ->first();

            return $settingValue;
        }

        return false;
    }

    if (!function_exists('putPermanentEnv'))
    {
        function putPermanentEnv($key, $value)
        {
            $path = app()->environmentFilePath();

            $escaped = preg_quote('=' . env($key), '/');

            file_put_contents($path, preg_replace(
                "/^{$key}{$escaped}/m",
                "{$key}={$value}",
                file_get_contents($path)
            ));
        }
    }

    if (!function_exists('deletePermanentEnv'))
    {
        function deletePermanentEnv($key)
        {
            $path = app()->environmentFilePath();

            $escaped = preg_quote('=' . env($key), '/');

            file_put_contents($path, preg_replace(
                "/^{$key}{$escaped}/m",
                "",
                file_get_contents($path)
            ));
        }
    }


    if (!function_exists('viewHelper'))
    {
        $components = [
            'SelectBox'
        ];
        /**
         * Get the evaluated view contents for the given view.
         *
         * @param  string
         * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
         */
        function viewHelper($componentPath)
        {
            return (new $componentPath())->render();
        }
    }
}
