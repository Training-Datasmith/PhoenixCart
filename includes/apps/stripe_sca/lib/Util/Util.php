<?php

declare (strict_types=1);
namespace Stripe\Util;

use Stripe\Stripe_Object;
abstract class Util
{
    private static ?bool $is_mbstring_available = null;
    private static ?bool $is_hash_equals_available = null;
    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     * A list is defined as an array for which all the keys are consecutive
     * integers starting at 0. Empty arrays are considered to be lists.
     *
     * @param array|mixed $array
     *
     * @return bool true if the given object is a list
     */
    public static function is_list($array)
    {
        if (!\is_array($array)) {
            return false;
        }
        if ([] === $array) {
            return true;
        }
        if (\array_keys($array) !== \range(0, \count($array) - 1)) {
            return false;
        }
        return true;
    }
    /**
     * Converts a response from the Stripe API to the corresponding PHP object.
     *
     * @param array $resp the response from the Stripe API
     * @param array $opts
     *
     * @return array|StripeObject
     */
    public static function convert_to_stripe_object($resp, $opts)
    {
        $types = \Stripe\Util\Object_Types::mapping;
        if (self::is_list($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                $mapped[] = self::convert_to_stripe_object($i, $opts);
            }
            return $mapped;
        }
        if (\is_array($resp)) {
            if (isset($resp['object']) && \is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
            } else {
                $class = \Stripe\Stripe_Object::class;
            }
            return $class::construct_from($resp, $opts);
        }
        return $resp;
    }
    /**
     * @param mixed|string $value a string to UTF8-encode
     *
     * @return mixed|string the UTF8-encoded string, or the object passed in if
     *    it wasn't a string
     */
    public static function utf8($value)
    {
        if (null === self::$is_mbstring_available) {
            self::$is_mbstring_available = \function_exists('mb_detect_encoding') && \function_exists('mb_convert_encoding');
            if (!self::$is_mbstring_available) {
                \trigger_error('It looks like the mbstring extension is not enabled. ' . 'UTF-8 strings will not properly be encoded. Ask your system ' . 'administrator to enable the mbstring extension, or write to ' . 'support@stripe.com if you have any questions.', \E_USER_WARNING);
            }
        }
        if (\is_string($value) && self::$is_mbstring_available && 'UTF-8' !== \mb_detect_encoding($value, 'UTF-8', true)) {
            return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
        }
        return $value;
    }
    /**
     * Compares two strings for equality. The time taken is independent of the
     * number of characters that match.
     *
     * @param string $a one of the strings to compare
     * @param string $b the other string to compare
     *
     * @return bool true if the strings are equal, false otherwise
     */
    public static function secure_compare($a, $b)
    {
        if (null === self::$is_hash_equals_available) {
            self::$is_hash_equals_available = \function_exists('hash_equals');
        }
        if (self::$is_hash_equals_available) {
            return \hash_equals($a, $b);
        }
        if (\strlen($a) !== \strlen($b)) {
            return false;
        }
        $result = 0;
        for ($i = 0; $i < \strlen($a); ++$i) {
            $result |= \ord($a[$i]) ^ \ord($b[$i]);
        }
        return 0 === $result;
    }
    /**
     * Recursively goes through an array of parameters. If a parameter is an instance of
     * ApiResource, then it is replaced by the resource's ID.
     * Also clears out null values.
     *
     * @param mixed $h
     *
     * @return mixed
     */
    public static function objects_to_ids($h)
    {
        if ($h instanceof \Stripe\Api_Resource) {
            return $h->id;
        }
        if (static::is_list($h)) {
            $results = [];
            foreach ($h as $v) {
                $results[] = static::objects_to_ids($v);
            }
            return $results;
        }
        if (\is_array($h)) {
            $results = [];
            foreach ($h as $k => $v) {
                if (null === $v) {
                    continue;
                }
                $results[$k] = static::objects_to_ids($v);
            }
            return $results;
        }
        return $h;
    }
    /**
     * @param array $params
     *
     * @return string
     */
    public static function encode_parameters($params)
    {
        $flattened_params = self::flatten_params($params);
        $pieces = [];
        foreach ($flattened_params as $param) {
            [$k, $v] = $param;
            $pieces[] = self::url_encode($k) . '=' . self::url_encode($v);
        }
        return \implode('&', $pieces);
    }
    /**
     * @param array $params
     * @param null|string $parentKey
     *
     * @return array
     */
    public static function flatten_params($params, $parent_key = null)
    {
        $result = [];
        foreach ($params as $key => $value) {
            $calculated_key = $parent_key ? "{$parent_key}[{$key}]" : $key;
            if (self::is_list($value)) {
                $result = \array_merge($result, self::flatten_params_list($value, $calculated_key));
            } elseif (\is_array($value)) {
                $result = \array_merge($result, self::flatten_params($value, $calculated_key));
            } else {
                \array_push($result, [$calculated_key, $value]);
            }
        }
        return $result;
    }
    /**
     * @param array $value
     * @param string $calculatedKey
     *
     * @return array
     */
    public static function flatten_params_list($value, $calculated_key)
    {
        $result = [];
        foreach ($value as $i => $elem) {
            if (self::is_list($elem)) {
                $result = \array_merge($result, self::flatten_params_list($elem, $calculated_key));
            } elseif (\is_array($elem)) {
                $result = \array_merge($result, self::flatten_params($elem, "{$calculated_key}[{$i}]"));
            } else {
                \array_push($result, ["{$calculated_key}[{$i}]", $elem]);
            }
        }
        return $result;
    }
    /**
     * @param string $key a string to URL-encode
     *
     * @return string the URL-encoded string
     */
    public static function url_encode($key)
    {
        $s = \urlencode((string) $key);
        // Don't use strict form encoding by changing the square bracket control
        // characters back to their literals. This is fine by the server, and
        // makes these parameter strings easier to read.
        $s = \str_replace('%5B', '[', $s);
        return \str_replace('%5D', ']', $s);
    }
    public static function normalize_id($id)
    {
        if (\is_array($id)) {
            $params = $id;
            $id = $params['id'];
            unset($params['id']);
        } else {
            $params = [];
        }
        return [$id, $params];
    }
    /**
     * Returns UNIX timestamp in milliseconds.
     *
     * @return int current time in millis
     */
    public static function current_time_millis()
    {
        return (int) \round(\microtime(true) * 1000);
    }
}