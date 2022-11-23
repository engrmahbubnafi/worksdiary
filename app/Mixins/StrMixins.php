<?php

namespace App\Mixins;

use App\Models\EmptyObj;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class StrMixins
{

    public function strSpacecase()
    {
        return function ($slug) {
            return str_replace(['-', '_'], " ", $slug);
        };
    }

    public function showDateWithFormat()
    {
        return function ($value, $format = 'd M, y') {
            $offset = request()->cookie('time_zone_offset') ?? 0;
            return Carbon::parse($value)->addMinutes((int) $offset)->format($format);
        };
    }

    public function showDateTimeWithFormat()
    {
        return function ($value, $format = "d M, y h:i A") {
            $offset = request()->cookie('time_zone_offset') ?? 0;
            return Carbon::parse($value)->addMinutes((int) $offset)->format($format);
        };
    }

    public function getDateFormInput()
    {
        return function ($value) {
            return Carbon::parse($value)->format('Y-m-d');
        };
    }

    public function diffForHumans()
    {
        return function ($value) {
            return Carbon::parse($value)->diffForHumans();
        };
    }

    public function numberFormat()
    {
        return function ($value, $point = 2) {
            return number_format((float) $value, $point, '.', '');
        };
    }

    public function mystudyCase()
    {
        return function ($value) {
            return ucwords(ucwords(str_replace(['-', '_'], ' ', $value)), '/');
        };
    }

    public function camelToSpace()
    {
        return function ($string) {
            return ucwords(implode(' ', preg_split('/(?=[A-Z])/', $string)));
        };
    }

    //get file name omiting/ignore un utf carecter
    public function getFileName()
    {
        return function ($string) {
            // Transliterate non-ascii characters to ascii
            $str = trim(strtolower($string));
            $str = iconv('UTF-8', 'ISO-8859-1//IGNORE', $str);

            // Do other search and replace
            $searches = [' ', '&', '/'];
            $replaces = ['-', 'and', '-'];
            $str = str_replace($searches, $replaces, $str);

            // Make sure we don't have more than one dash together because that's ugly
            $str = preg_replace("/(-{2,})/", "-", $str);

            // Remove all invalid characters
            $str = preg_replace("/[^A-Za-z0-9-.]/", "", $str);

            $str = substr($str, strlen($str) - 50);
            // Done!
            return $str;
        };
    }

    // $n indicates how many characters you want ex: 1 => 0001
    public function numberPad()
    {
        return function ($number, $n) {
            return str_pad((int) $number, $n, "0", STR_PAD_LEFT);
        };
    }

    public function round()
    {
        return function ($number, $length = null) {

            if ($length) {
                return number_format((float) $number, $length);
            }

            $newNumber = (float) $number;

            if (strpos($newNumber, ".")) {

                $precisionLength = strlen((string) explode(".", $newNumber)[1]);

                if ($precisionLength < 2) {
                    return number_format($newNumber, 2);
                } else {
                    return number_format($newNumber, $precisionLength);
                }
            } else {
                return number_format($newNumber, 2);
            }
        };
    }

    //delete array element by value
    public function deleteElement()
    {
        return function ($element, &$array) {
            $index = array_search($element, $array);
            if ($index !== false) {
                unset($array[$index]);
            }
        };
    }

    public function trimAll()
    {
        return function ($str, $what = null, $with = ' ') {
            if ($what === null) {
                //  Character      Decimal      Use
                //  "\0"            0           Null Character
                //  "\t"            9           Tab
                //  "\n"           10           New line
                //  "\x0B"         11           Vertical Tab
                //  "\r"           13           New Line in Mac
                //  " "            32           Space

                $what = "\\x00-\\x20"; //all white-spaces and control chars
            }

            return trim(preg_replace("/[" . $what . "]+/", $with, $str), $what);
        };
    }

    public function getAbsolute()
    {
        return function (string $path): string {
            // Cleaning path regarding OS
            $path = mb_ereg_replace('\\\\|/', DIRECTORY_SEPARATOR, $path, 'msr');
            // Check if path start with a separator (UNIX)
            $startWithSeparator = $path[0] === DIRECTORY_SEPARATOR;
            // Check if start with drive letter
            preg_match('/^[a-z]:/', $path, $matches);
            $startWithLetterDir = isset($matches[0]) ? $matches[0] : false;
            // Get and filter empty sub paths
            $subPaths = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'mb_strlen');

            $absolutes = [];
            foreach ($subPaths as $subPath) {
                if ('.' === $subPath) {
                    continue;
                }
                // if $startWithSeparator is false
                // and $startWithLetterDir
                // and (absolutes is empty or all previous values are ..)
                // save absolute cause that's a relative and we can't deal with that and just forget that we want go up
                if (
                    '..' === $subPath
                    && !$startWithSeparator
                    && !$startWithLetterDir
                    && empty(array_filter($absolutes, function ($value) {
                        return !('..' === $value);
                    }))
                ) {
                    $absolutes[] = $subPath;
                    continue;
                }
                if ('..' === $subPath) {
                    array_pop($absolutes);
                    continue;
                }
                $absolutes[] = $subPath;
            }

            return (($startWithSeparator ? DIRECTORY_SEPARATOR : $startWithLetterDir) ?
                $startWithLetterDir . DIRECTORY_SEPARATOR : ''
            ) . implode(DIRECTORY_SEPARATOR, $absolutes);
        };
    }

    public function timeFormat()
    {
        return function ($init = 10800) {
            $hours = floor($init / 3600);
            $minutes = floor(($init / 60) % 60);
            $seconds = $init % 60;

            if ($hours) {
                $formatedString1 = ($hours > 1) ? ' hours' : ' hour';
                $formated[] = $hours . $formatedString1;
            }

            if ($minutes) {
                $formatedString2 = ($minutes > 1) ? ' minutes' : ' minute';
                $formated[] = $minutes . $formatedString2;
            }

            if ($seconds) {
                $formatedString3 = ($seconds > 1) ? ' seconds' : ' second';
                $formated[] = $seconds . $formatedString3;
            }
            return implode(' ', $formated);
        };
    }

    public function daysToSeconds()
    {
        return function (int $days = null) {
            if ($days) {
                return (int) $days * 24 * 60 * 60;
            }
            return 0;
        };
    }

    public function getNextArrKey()
    {
        return function (array $arr, string $key) {
            if (Arr::isAssoc($arr)) {

                $arr = array_keys($arr);

                $currentKey = array_search($key, $arr);

                return Arr::get($arr, $currentKey + 1);
            }

            return false;
        };
    }

    public function arrayToObject()
    {
        return function (array $arr, int $level) {
            if (!$level) {
                $level = 1;
            }

            if ($level == 1) {
                return (new EmptyObj)->setRawAttributes($arr);
            }

            if ($level == 2) {
                $newArr = [];
                foreach ($arr as $k => $val) {
                    if (is_array($val)) {
                        $newArr[$k] = (new EmptyObj)->setRawAttributes($val);
                    } else {
                        $newArr[$k] = $val;
                    }
                }
                return (new EmptyObj)->setRawAttributes($newArr);
            }
        };
    }

    public function checkDBConnection()
    {
        return function () {
            try {
                $status = Schema::hasTable('users');
                return $status;
            } catch (\Throwable $e) {
                return false;
            }
        };
    }

    public function isMenuRender()
    {
        return function ($needle, $haystackArr) {
            if (is_array($needle)) {
                $result = array_intersect($needle, $haystackArr);
                if (count($result) > 0) {
                    return true;
                }
            } else {
                if (in_array($needle, $haystackArr)) {
                    return true;
                }
            }
            return false;
        };
    }

    public function checkMenuActive()
    {
        return function ($current_location, $options, $parent = false) {
            if ($parent) {
                if (in_array($current_location, (array) $options)) {
                    return 'here show';
                }
            } else {
                if (is_array($options)) {
                    $currentParams = array_values(Route::current()->parameters());
                    if ($current_location == $options[0] && $currentParams == $options[1]) {
                        return 'active';
                    }
                } else {
                    if ($current_location == $options) {
                        return 'active';
                    }
                }
            }
            return '';
        };
    }

    public function checkMenuActiveWithParam()
    {
        return function ($routeNameArr = [], $param = []) {
            $currentRouteName = Route::currentRouteName();
            $currentParams = Route::current()->parameters();
            if (count($param)) {
                $intersectArr = array_intersect($currentParams, $param);
                if (in_array($currentRouteName, $routeNameArr) && count($intersectArr)) {
                    return true;
                }
            } else {
                if (in_array($currentRouteName, $routeNameArr)) {
                    return true;
                }
            }
            return false;
        };
    }

    public function profileMenuActive()
    {
        return function ($routeName, $groupType, $params = null) {

            $selected = false;

            $currentRouteName = Route::currentRouteName();

            if ($routeName == $groupType . '.profile') {
                $currentParams = Route::current()->parameters();
                $currentParam = Arr::get($currentParams, $groupType, 'overview');

                if ($params && is_array($params) && in_array($currentParam, $params)) {
                    $selected = true;
                } else if ($params && $currentParam == $params) {
                    $selected = true;
                }
            } elseif ($currentRouteName == $routeName) {
                $selected = true;
            }

            if ($selected) {
                return 'active';
            }
        };
    }

    public function wrapImplode()
    {
        return function ($array, $before = '', $after = '', $separator = '') {
            if (!$array) {
                return '';
            }
            return $before . implode("{$after}{$separator}{$before}", $array) . $after;
        };
    }

    public function generateCompanyTab()
    {
        return function ($routeName, $hasInitial = false, $firstTabTitle = 'All') {

            $authCompanies = app('authCompanies');

            $lists = [];

            $i = 0;

            if ($hasInitial) {
                $lists = [
                    (new EmptyObj())->setRawAttributes([
                        'id' => null,
                        'params' => null,
                        'route_name' => $routeName,
                        'title' => $firstTabTitle,
                    ]),
                ];

                $i++;
            }

            foreach ($authCompanies as $company_id => $company) {

                if (!$hasInitial && $company_id == auth()->user()->company_id) {
                    $params = null;
                } else {
                    $params = $company_id;
                }

                $lists[$i] = (new EmptyObj())->setRawAttributes([
                    'id' => $company_id,
                    'params' => $params,
                    'route_name' => $routeName,
                    'title' => $company,
                ]);
                $i++;
            }
            // dd($lists);
            return collect($lists);
        };
    }
}
