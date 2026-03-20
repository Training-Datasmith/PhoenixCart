<?php

declare (strict_types=1);
namespace Stripe\Util;

/**
 * CaseInsensitiveArray is an array-like class that ignores case for keys.
 *
 * It is used to store HTTP headers. Per RFC 2616, section 4.2:
 * Each header field consists of a name followed by a colon (":") and the field value. Field names
 * are case-insensitive.
 *
 * In the context of stripe-php, this is useful because the API will return headers with different
 * case depending on whether HTTP/2 is used or not (with HTTP/2, headers are always in lowercase).
 */
class Case_Insensitive_Array implements \ArrayAccess, \Countable, \IteratorAggregate
{
    private array $container;
    public function __construct($initial_array = [])
    {
        $this->container = \array_change_key_case($initial_array, \CASE_LOWER);
    }
    /**
     * @return int
     */
    #[\Return_Type_Will_Change]
    public function count()
    {
        return \count($this->container);
    }
    /**
     * @return \ArrayIterator
     */
    #[\Return_Type_Will_Change]
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }
    #[\Return_Type_Will_Change]
    public function offsetSet($offset, $value): void
    {
        $offset = static::maybe_lowercase($offset);
        if (null === $offset) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    /**
     * @return bool
     */
    #[\Return_Type_Will_Change]
    public function offsetExists($offset)
    {
        $offset = static::maybe_lowercase($offset);
        return isset($this->container[$offset]);
    }
    #[\Return_Type_Will_Change]
    public function offsetUnset($offset): void
    {
        $offset = static::maybe_lowercase($offset);
        unset($this->container[$offset]);
    }
    /**
     * @return mixed
     */
    #[\Return_Type_Will_Change]
    public function offsetGet($offset)
    {
        $offset = static::maybe_lowercase($offset);
        return $this->container[$offset] ?? null;
    }
    private static function maybe_lowercase($v)
    {
        if (\is_string($v)) {
            return \strtolower($v);
        }
        return $v;
    }
}