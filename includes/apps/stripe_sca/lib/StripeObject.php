<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Class StripeObject.
 */
class Stripe_Object implements \ArrayAccess, \Countable, \JsonSerializable, \Stringable
{
    /** @var Util\RequestOptions */
    protected $_opts;
    protected array $_original_values;
    protected array $_values;
    protected \Stripe\Util\Set $_unsaved_values;
    protected \Stripe\Util\Set $_transient_values;
    /** @var null|array */
    protected $_retrieve_options;
    /** @var null|ApiResponse */
    protected $_last_response;
    /**
     * @return Util\Set Attributes that should not be sent to the API because
     *    they're not updatable (e.g. ID).
     */
    public static function get_permanent_attributes()
    {
        static $permanent_attributes = null;
        if (null === $permanent_attributes) {
            $permanent_attributes = new Util\Set(['id']);
        }
        return $permanent_attributes;
    }
    /**
     * Additive objects are subobjects in the API that don't have the same
     * semantics as most subobjects, which are fully replaced when they're set.
     *
     * This is best illustrated by example. The `source` parameter sent when
     * updating a subscription is *not* additive; if we set it:
     *
     *     source[object]=card&source[number]=123
     *
     * We expect the old `source` object to have been overwritten completely. If
     * the previous source had an `address_state` key associated with it and we
     * didn't send one this time, that value of `address_state` is gone.
     *
     * By contrast, additive objects are those that will have new data added to
     * them while keeping any existing data in place. The only known case of its
     * use is for `metadata`, but it could in theory be more general. As an
     * example, say we have a `metadata` object that looks like this on the
     * server side:
     *
     *     metadata = ["old" => "old_value"]
     *
     * If we update the object with `metadata[new]=new_value`, the server side
     * object now has *both* fields:
     *
     *     metadata = ["old" => "old_value", "new" => "new_value"]
     *
     * This is okay in itself because usually users will want to treat it as
     * additive:
     *
     *     $obj->metadata["new"] = "new_value";
     *     $obj->save();
     *
     * However, in other cases, they may want to replace the entire existing
     * contents:
     *
     *     $obj->metadata = ["new" => "new_value"];
     *     $obj->save();
     *
     * This is where things get a little bit tricky because in order to clear
     * any old keys that may have existed, we actually have to send an explicit
     * empty string to the server. So the operation above would have to send
     * this form to get the intended behavior:
     *
     *     metadata[old]=&metadata[new]=new_value
     *
     * This method allows us to track which parameters are considered additive,
     * and lets us behave correctly where appropriate when serializing
     * parameters to be sent.
     *
     * @return Util\Set Set of additive parameters
     */
    public static function get_additive_params()
    {
        static $additive_params = null;
        if (null === $additive_params) {
            // Set `metadata` as additive so that when it's set directly we remember
            // to clear keys that may have been previously set by sending empty
            // values for them.
            //
            // It's possible that not every object has `metadata`, but having this
            // option set when there is no `metadata` field is not harmful.
            $additive_params = new Util\Set(['metadata']);
        }
        return $additive_params;
    }
    public function __construct($id = null, $opts = null)
    {
        [$id, $this->_retrieve_options] = Util\Util::normalize_id($id);
        $this->_opts = Util\Request_Options::parse($opts);
        $this->_original_values = [];
        $this->_values = [];
        $this->_unsaved_values = new Util\Set();
        $this->_transient_values = new Util\Set();
        if (null !== $id) {
            $this->_values['id'] = $id;
        }
    }
    // Standard accessor magic methods
    public function __set(string $k, mixed $v)
    {
        if (static::get_permanent_attributes()->includes($k)) {
            throw new Exception\InvalidArgumentException("Cannot set {$k} on this object. HINT: you can't set: " . \implode(', ', static::get_permanent_attributes()->to_array()));
        }
        if ('' === $v) {
            throw new Exception\InvalidArgumentException('You cannot set \'' . $k . '\'to an empty string. ' . 'We interpret empty strings as NULL in requests. ' . 'You may set obj->' . $k . ' = NULL to delete the property');
        }
        $this->_values[$k] = Util\Util::convert_to_stripe_object($v, $this->_opts);
        $this->dirty_value($this->_values[$k]);
        $this->_unsaved_values->add($k);
    }
    /**
     * @param mixed $k
     *
     * @return bool
     */
    public function __isset(string $k)
    {
        return isset($this->_values[$k]);
    }
    public function __unset(string $k)
    {
        unset($this->_values[$k]);
        $this->_transient_values->add($k);
        $this->_unsaved_values->discard($k);
    }
    public function &__get(string $k): mixed
    {
        // function should return a reference, using $nullval to return a reference to null
        $nullval = null;
        if (!empty($this->_values) && \array_key_exists($k, $this->_values)) {
            return $this->_values[$k];
        }
        if (!empty($this->_transient_values) && $this->_transient_values->includes($k)) {
            $class = static::class;
            $attrs = \implode(', ', \array_keys($this->_values));
            $message = "Stripe Notice: Undefined property of {$class} instance: {$k}. " . "HINT: The {$k} attribute was set in the past, however. " . 'It was then wiped when refreshing the object ' . "with the result returned by Stripe's API, " . 'probably as a result of a save(). The attributes currently ' . "available on this object are: {$attrs}";
            Stripe::get_logger()->error($message);
            return $nullval;
        }
        $class = static::class;
        Stripe::get_logger()->error("Stripe Notice: Undefined property of {$class} instance: {$k}");
        return $nullval;
    }
    /**
     * Magic method for var_dump output. Only works with PHP >= 5.6.
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->_values;
    }
    // ArrayAccess methods
    #[\Return_Type_Will_Change]
    public function offsetSet($k, $v): void
    {
        $this->{$k} = $v;
    }
    /**
     * @return bool
     */
    #[\Return_Type_Will_Change]
    public function offsetExists($k)
    {
        return \array_key_exists($k, $this->_values);
    }
    #[\Return_Type_Will_Change]
    public function offsetUnset($k): void
    {
        unset($this->{$k});
    }
    /**
     * @return mixed
     */
    #[\Return_Type_Will_Change]
    public function offsetGet($k)
    {
        return \array_key_exists($k, $this->_values) ? $this->_values[$k] : null;
    }
    /**
     * @return int
     */
    #[\Return_Type_Will_Change]
    public function count()
    {
        return \count($this->_values);
    }
    public function keys(): array
    {
        return \array_keys($this->_values);
    }
    public function values(): array
    {
        return \array_values($this->_values);
    }
    /**
     * This unfortunately needs to be public to be used in Util\Util.
     *
     * @param null|array|string|Util\RequestOptions $opts
     * @return static the object constructed from the given values
     */
    public static function construct_from(array $values, $opts = null): static
    {
        $obj = new static($values['id'] ?? null);
        $obj->refresh_from($values, $opts);
        return $obj;
    }
    /**
     * Refreshes this object using the provided values.
     *
     * @param array $values
     * @param null|array|string|Util\RequestOptions $opts
     * @param bool $partial defaults to false
     */
    public function refresh_from($values, $opts, $partial = false): void
    {
        $this->_opts = Util\Request_Options::parse($opts);
        $this->_original_values = self::deep_copy($values);
        if ($values instanceof Stripe_Object) {
            $values = $values->to_array();
        }
        // Wipe old state before setting new.  This is useful for e.g. updating a
        // customer, where there is no persistent card parameter.  Mark those values
        // which don't persist as transient
        if ($partial) {
            $removed = new Util\Set();
        } else {
            $removed = new Util\Set(\array_diff(\array_keys($this->_values), \array_keys($values)));
        }
        foreach ($removed->to_array() as $k) {
            unset($this->{$k});
        }
        $this->update_attributes($values, $opts, false);
        foreach ($values as $k => $v) {
            $this->_transient_values->discard($k);
            $this->_unsaved_values->discard($k);
        }
    }
    /**
     * Mass assigns attributes on the model.
     *
     * @param array $values
     * @param null|array|string|Util\RequestOptions $opts
     * @param bool $dirty defaults to true
     */
    public function update_attributes($values, $opts = null, $dirty = true): void
    {
        foreach ($values as $k => $v) {
            // Special-case metadata to always be cast as a StripeObject
            // This is necessary in case metadata is empty, as PHP arrays do
            // not differentiate between lists and hashes, and we consider
            // empty arrays to be lists.
            if ('metadata' === $k && \is_array($v)) {
                $this->_values[$k] = Stripe_Object::construct_from($v, $opts);
            } else {
                $this->_values[$k] = Util\Util::convert_to_stripe_object($v, $opts);
            }
            if ($dirty) {
                $this->dirty_value($this->_values[$k]);
            }
            $this->_unsaved_values->add($k);
        }
    }
    /**
     * @param bool $force defaults to false
     *
     * @return array a recursive mapping of attributes to values for this object,
     *    including the proper value for deleted attributes
     */
    public function serialize_parameters($force = false): array
    {
        $update_params = [];
        foreach ($this->_values as $k => $v) {
            // There are a few reasons that we may want to add in a parameter for
            // update:
            //
            //   1. The `$force` option has been set.
            //   2. We know that it was modified.
            //   3. Its value is a StripeObject. A StripeObject may contain modified
            //      values within in that its parent StripeObject doesn't know about.
            //
            $original = \array_key_exists($k, $this->_original_values) ? $this->_original_values[$k] : null;
            $unsaved = $this->_unsaved_values->includes($k);
            if ($force || $unsaved || $v instanceof Stripe_Object) {
                $update_params[$k] = $this->serialize_params_value($this->_values[$k], $original, $unsaved, $force, $k);
            }
        }
        // a `null` that makes it out of `serializeParamsValue` signals an empty
        // value that we shouldn't appear in the serialized form of the object
        return \array_filter($update_params, fn($v) => null !== $v);
    }
    public function serialize_params_value($value, $original, $unsaved, $force, $key = null)
    {
        // The logic here is that essentially any object embedded in another
        // object that had a `type` is actually an API resource of a different
        // type that's been included in the response. These other resources must
        // be updated from their proper endpoints, and therefore they are not
        // included when serializing even if they've been modified.
        //
        // There are _some_ known exceptions though.
        //
        // For example, if the value is unsaved (meaning the user has set it), and
        // it looks like the API resource is persisted with an ID, then we include
        // the object so that parameters are serialized with a reference to its
        // ID.
        //
        // Another example is that on save API calls it's sometimes desirable to
        // update a customer's default source by setting a new card (or other)
        // object with `->source=` and then saving the customer. The
        // `saveWithParent` flag to override the default behavior allows us to
        // handle these exceptions.
        //
        // We throw an error if a property was set explicitly but we can't do
        // anything with it because the integration is probably not working as the
        // user intended it to.
        if (null === $value) {
            return '';
        }
        if ($value instanceof Api_Resource && !$value->save_with_parent) {
            if (!$unsaved) {
                return null;
            }
            if (isset($value->id)) {
                return $value;
            }
            throw new Exception\InvalidArgumentException("Cannot save property `{$key}` containing an API resource of type " . $value::class . ". It doesn't appear to be persisted and is " . 'not marked as `saveWithParent`.');
        }
        if (\is_array($value)) {
            if (Util\Util::is_list($value)) {
                // Sequential array, i.e. a list
                $update = [];
                foreach ($value as $v) {
                    $update[] = $this->serialize_params_value($v, null, true, $force);
                }
                // This prevents an array that's unchanged from being resent.
                if ($update !== $this->serialize_params_value($original, null, true, $force, $key)) {
                    return $update;
                }
            } else {
                // Associative array, i.e. a map
                return Util\Util::convert_to_stripe_object($value, $this->_opts)->serialize_parameters();
            }
        } elseif ($value instanceof Stripe_Object) {
            $update = $value->serialize_parameters($force);
            if ($original && $unsaved && $key && static::get_additive_params()->includes($key)) {
                return \array_merge(self::empty_values($original), $update);
            }
            return $update;
        } else {
            return $value;
        }
    }
    /**
     * @return mixed
     */
    #[\Return_Type_Will_Change]
    public function jsonSerialize()
    {
        return $this->to_array();
    }
    /**
     * Returns an associative array with the key and values composing the
     * Stripe object.
     *
     * @return array the associative array
     */
    public function to_array(): mixed
    {
        $maybe_to_array = function ($value) {
            if (null === $value) {
                return null;
            }
            return \is_object($value) && \method_exists($value, 'toArray') ? $value->to_array() : $value;
        };
        return \array_reduce(\array_keys($this->_values), function (array $acc, int|string $k) use ($maybe_to_array): array {
            if (str_starts_with((string) $k, '_')) {
                return $acc;
            }
            $v = $this->_values[$k];
            if (Util\Util::is_list($v)) {
                $acc[$k] = \array_map($maybe_to_array, $v);
            } else {
                $acc[$k] = $maybe_to_array($v);
            }
            return $acc;
        }, []);
    }
    /**
     * Returns a pretty JSON representation of the Stripe object.
     *
     * @return string the JSON representation of the Stripe object
     */
    public function to_json()
    {
        return \json_encode($this->to_array(), \JSON_PRETTY_PRINT);
    }
    public function __toString(): string
    {
        $class = static::class;
        return $class . ' JSON: ' . $this->to_json();
    }
    /**
     * Sets all keys within the StripeObject as unsaved so that they will be
     * included with an update when `serializeParameters` is called. This
     * method is also recursive, so any StripeObjects contained as values or
     * which are values in a tenant array are also marked as dirty.
     */
    public function dirty(): void
    {
        $this->_unsaved_values = new Util\Set(\array_keys($this->_values));
        foreach ($this->_values as $v) {
            $this->dirty_value($v);
        }
    }
    protected function dirty_value($value)
    {
        if (\is_array($value)) {
            foreach ($value as $v) {
                $this->dirty_value($v);
            }
        } elseif ($value instanceof Stripe_Object) {
            $value->dirty();
        }
    }
    /**
     * Produces a deep copy of the given object including support for arrays
     * and StripeObjects.
     *
     * @param mixed $obj
     */
    protected static function deep_copy($obj)
    {
        if (\is_array($obj)) {
            $copy = [];
            foreach ($obj as $k => $v) {
                $copy[$k] = self::deep_copy($v);
            }
            return $copy;
        }
        if ($obj instanceof Stripe_Object) {
            return $obj::construct_from(self::deep_copy($obj->_values), clone $obj->_opts);
        }
        return $obj;
    }
    /**
     * Returns a hash of empty values for all the values that are in the given
     * StripeObject.
     *
     * @param mixed $obj
     */
    public static function empty_values($obj): array
    {
        if (\is_array($obj)) {
            $values = $obj;
        } elseif ($obj instanceof Stripe_Object) {
            $values = $obj->_values;
        } else {
            throw new Exception\InvalidArgumentException('empty_values got unexpected object type: ' . $obj::class);
        }
        return \array_fill_keys(\array_keys($values), '');
    }
    /**
     * @return null|ApiResponse The last response from the Stripe API
     */
    public function get_last_response()
    {
        return $this->_last_response;
    }
    /**
     * Sets the last response from the Stripe API.
     *
     * @param ApiResponse $resp
     */
    public function set_last_response($resp): void
    {
        $this->_last_response = $resp;
    }
    /**
     * Indicates whether or not the resource has been deleted on the server.
     * Note that some, but not all, resources can indicate whether they have
     * been deleted.
     *
     * @return bool whether the resource is deleted
     */
    public function is_deleted()
    {
        return $this->_values['deleted'] ?? false;
    }
}