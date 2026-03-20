<?php

declare (strict_types=1);
namespace Stripe;

/**
 * Class ApiResource.
 */
abstract class Api_Resource extends Stripe_Object
{
    use Api_Operations\Request;
    /**
     * @return \Stripe\Util\Set A list of fields that can be their own type of
     * API resource (say a nested card under an account for example), and if
     * that resource is set, it should be transmitted to the API on a create or
     * update. Doing so is not the default behavior because API resources
     * should normally be persisted on their own RESTful endpoints.
     */
    public static function get_saved_nested_resources()
    {
        static $saved_nested_resources = null;
        if (null === $saved_nested_resources) {
            $saved_nested_resources = new Util\Set();
        }
        return $saved_nested_resources;
    }
    /**
     * @var bool A flag that can be set a behavior that will cause this
     * resource to be encoded and sent up along with an update of its parent
     * resource. This is usually not desirable because resources are updated
     * individually on their own endpoints, but there are certain cases,
     * replacing a customer's source for example, where this is allowed.
     */
    public $save_with_parent = false;
    public function __set($k, $v)
    {
        parent::__set($k, $v);
        $v = $this->{$k};
        if (static::get_saved_nested_resources()->includes($k) && $v instanceof Api_Resource) {
            $v->save_with_parent = true;
        }
    }
    /**
     * @throws Exception\ApiErrorException
     *
     * @return ApiResource the refreshed resource
     */
    public function refresh()
    {
        $requestor = new Api_Requestor($this->_opts->api_key, static::base_url());
        $url = $this->instance_url();
        [$response, $this->_opts->api_key] = $requestor->request('get', $url, $this->_retrieve_options, $this->_opts->headers);
        $this->set_last_response($response);
        $this->refresh_from($response->json, $this->_opts);
        return $this;
    }
    /**
     * @return string the base URL for the given class
     */
    public static function base_url()
    {
        return Stripe::$api_base;
    }
    /**
     * @return string the endpoint URL for the given class
     */
    public static function class_url()
    {
        // Replace dots with slashes for namespaced resources, e.g. if the object's name is
        // "foo.bar", then its URL will be "/v1/foo/bars".
        /** @phpstan-ignore-next-line */
        $base = \str_replace('.', '/', static::OBJECT_NAME);
        return "/v1/{$base}s";
    }
    /**
     * @param null|string $id the ID of the resource
     *
     * @throws Exception\UnexpectedValueException if $id is null
     *
     * @return string the instance endpoint URL for the given class
     */
    public static function resource_url($id)
    {
        if (null === $id) {
            $class = static::class;
            $message = 'Could not determine which URL to request: ' . "{$class} instance has invalid ID: {$id}";
            throw new Exception\UnexpectedValueException($message);
        }
        $id = Util\Util::utf8($id);
        $base = static::class_url();
        $extn = \urlencode((string) $id);
        return "{$base}/{$extn}";
    }
    /**
     * @return string the full API URL for this API resource
     */
    public function instance_url()
    {
        return static::resource_url($this['id']);
    }
}