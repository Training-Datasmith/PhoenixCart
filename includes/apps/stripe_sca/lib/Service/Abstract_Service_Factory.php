<?php

declare (strict_types=1);
namespace Stripe\Service;

/**
 * Abstract base class for all service factories used to expose service
 * instances through {@link \Stripe\StripeClient}.
 *
 * Service factories serve two purposes:
 *
 * 1. Expose properties for all services through the `__get()` magic method.
 * 2. Lazily initialize each service instance the first time the property for
 *    a given service is used.
 */
abstract class Abstract_Service_Factory
{
    /** @var array<string, AbstractService|AbstractServiceFactory> */
    private array $services;
    /**
     * @param \Stripe\StripeClientInterface $client
     */
    public function __construct(private $client)
    {
        $this->services = [];
    }
    /**
     * @param string $name
     *
     * @return null|string
     */
    abstract protected function get_service_class($name);
    /**
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function __get(string $name): mixed
    {
        return $this->get_service($name);
    }
    /**
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function get_service(string $name)
    {
        $service_class = $this->get_service_class($name);
        if (null !== $service_class) {
            if (!\array_key_exists($name, $this->services)) {
                $this->services[$name] = new $service_class($this->client);
            }
            return $this->services[$name];
        }
        \trigger_error('Undefined property: ' . static::class . '::$' . $name);
        return null;
    }
}