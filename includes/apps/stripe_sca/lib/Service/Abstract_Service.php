<?php

declare (strict_types=1);
namespace Stripe\Service;

/**
 * Abstract base class for all services.
 */
abstract class Abstract_Service
{
    /**
     * @var \Stripe\StripeStreamingClientInterface
     */
    protected $streaming_client;
    /**
     * Initializes a new instance of the {@link AbstractService} class.
     *
     * @param \Stripe\StripeClientInterface $client
     */
    public function __construct(protected $client)
    {
        $this->streaming_client = $this->client;
    }
    /**
     * Gets the client used by this service to send requests.
     *
     * @return \Stripe\StripeClientInterface
     */
    public function get_client()
    {
        return $this->client;
    }
    /**
     * Gets the client used by this service to send requests.
     *
     * @return \Stripe\StripeStreamingClientInterface
     */
    public function get_streaming_client()
    {
        return $this->streaming_client;
    }
    /**
     * Translate null values to empty strings. For service methods,
     * we interpret null as a request to unset the field, which
     * corresponds to sending an empty string for the field to the
     * API.
     *
     * @param null|array $params
     */
    private static function format_params($params)
    {
        if (null === $params) {
            return null;
        }
        \array_walk_recursive($params, function (&$value, $key): void {
            if (null === $value) {
                $value = '';
            }
        });
        return $params;
    }
    protected function request($method, $path, $params, $opts)
    {
        return $this->get_client()->request($method, $path, static::format_params($params), $opts);
    }
    protected function request_stream($method, $path, $read_body_chunk_callable, $params, $opts)
    {
        return $this->get_streaming_client()->request_stream($method, $path, $read_body_chunk_callable, static::format_params($params), $opts);
    }
    protected function request_collection($method, $path, $params, $opts)
    {
        return $this->get_client()->request_collection($method, $path, static::format_params($params), $opts);
    }
    protected function request_search_result($method, $path, $params, $opts)
    {
        return $this->get_client()->request_search_result($method, $path, static::format_params($params), $opts);
    }
    protected function build_path($base_path, ...$ids)
    {
        foreach ($ids as $id) {
            if (null === $id || '' === \trim($id)) {
                $msg = 'The resource ID cannot be null or whitespace.';
                throw new \Stripe\Exception\InvalidArgumentException($msg);
            }
        }
        return \sprintf($base_path, ...\array_map(\urlencode(...), $ids));
    }
}