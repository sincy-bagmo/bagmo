<?php


namespace App\Http\Helpers\Core;


class LookupHelper
{

    /**
     * Find lookup value from key value pair
     *
     * @param array $collection
     * @param string $key
     * @param string $default
     * @param boolean $escape
     * @return string
     */
    public static function lookup($collection, $key, $default = '---', $escape = true)
    {
        $value = $default;
        if (isset($collection[$key])) {
            if ($escape && ! is_array($collection[$key])) {
                $value = self::escapeHtml($collection[$key]);
            } else {
                $value = $collection[$key];
            }
        }
        return $value;
    }

    /**
     * Find lookup value from Multi Dimensional array as key value pair
     *
     * @param array $collection
     * @param string $key
     * @param string $subKey
     * @param string $default
     * @param bool $escape
     * @return mixed|string
     */
    public static function lookupMultiDimensional($collection, $key, $subKey, $default = '', $escape = true)
    {
        $value = $default;
        if (isset($collection[$key][$subKey])) {
            if ($escape) {
                $value = self::escapeHtml($collection[$key][$subKey]);
            } else {
                $value = $collection[$key][$subKey];
            }
        }
        return $value;
    }

    /**
     * escape html
     *
     * @param string $string
     * @param boolean $doubleEncode
     * @return string
     */
    public static function escapeHtml($string, $doubleEncode = false)
    {
        return htmlspecialchars($string, ENT_COMPAT, 'UTF-8', $doubleEncode);
    }

}
