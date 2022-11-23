<?php

namespace App\Abilities;

use Illuminate\Support\Arr;

class LayoutClass
{

    public static function getConfig($string)
    {
        return config('layouts.' . $string);
    }

    public static function setConfig($key, $value)
    {
        config()->set('layouts.' . $key, $value);
    }

    private static $bodyClasses = [
        "header-fixed",
        "header-tablet-and-mobile-fixed",
        "toolbar-enabled",
        "toolbar-fixed",
        "aside-enabled",
        "aside-fixed",
    ];

    private static $guestBodyClasses = [];

    private static $bodyCssVariables = [
        '--kt-toolbar-height' => '55px',
        '--kt-toolbar-height-tablet-and-mobile' => '55px',
    ];

    private static $guestBodyCssVariables = [];

    private static function getBodyClass()
    {
        $arr = array_combine(self::$bodyClasses, self::$bodyClasses);

        if (!config('layouts.subheader.enable')) {
            Arr::forget($arr, ["toolbar-enabled", "toolbar-fixed"]);
        }

        if (!config('layouts.subheader.fixed')) {
            Arr::forget($arr, ["toolbar-fixed"]);
        }

        return Arr::join(array_values($arr), " ");

    }

    private static function getGuestBodyClass()
    {
        $arr = array_combine(self::$guestBodyClasses, self::$guestBodyClasses);

        if (!config('layouts.subheader.enable')) {
            Arr::forget($arr, ["toolbar-enabled", "toolbar-fixed"]);
        }

        if (!config('layouts.subheader.fixed')) {
            Arr::forget($arr, ["toolbar-fixed"]);
        }

        return Arr::join(array_values($arr), " ");

    }

    public static function setBodyClass($classes)
    {
        $revableClassList = explode(' ', $classes);

        foreach ($revableClassList as $class) {
            if (array_search($class, self::$bodyClasses) === false) {
                self::$bodyClasses[] = $class;
            }
        }
    }

    public static function setGuestBodyClass($classes)
    {
        $revableClassList = explode(' ', $classes);

        foreach ($revableClassList as $class) {
            if (array_search($class, self::$guestBodyClasses) === false) {
                self::$guestBodyClasses[] = $class;
            }
        }
    }

    public static function removeBodyClass($classes)
    {
        $revableClassList = explode(' ', $classes);

        foreach ($revableClassList as $class) {
            if (($key = array_search($class, self::$bodyClasses)) !== false) {
                unset(self::$bodyClasses[$key]);
            }
        }
    }

    public static function removeGuestBodyClass($classes)
    {
        $revableClassList = explode(' ', $classes);

        foreach ($revableClassList as $class) {
            if (($key = array_search($class, self::$guestBodyClasses)) !== false) {
                unset(self::$guestBodyClasses[$key]);
            }
        }
    }

    public static function printBodyClasses()
    {
        return self::getBodyClass();
    }

    public static function printGuestBodyClasses()
    {
        return self::getGuestBodyClass();
    }

    private static function getBodyCssVariables()
    {
        return self::$bodyCssVariables;
    }

    private static function getGuestBodyCssVariables()
    {
        return self::$guestBodyCssVariables;
    }

    public static function printBodyCssVariables()
    {
        return str_replace('=', ':', http_build_query(self::getBodyCssVariables(), '', ';'));
    }

    public static function printGuestBodyCssVariables()
    {
        return str_replace('=', ':', http_build_query(self::getGuestBodyCssVariables(), '', ';'));
    }
}
