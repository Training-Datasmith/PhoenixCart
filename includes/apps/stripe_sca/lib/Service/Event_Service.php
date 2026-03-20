<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class Event_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * List events, going back up to 30 days. Each event data is rendered according to
     * Stripe API version at its creation time, specified in <a
     * href="/docs/api/events/object">event object</a> <code>api_version</code>
     * attribute (not according to your current Stripe API version or
     * <code>Stripe-Version</code> header).
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Event>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/events', $params, $opts);
    }
    /**
     * Retrieves the details of an event. Supply the unique identifier of the event,
     * which you might have received in a webhook.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Event
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/events/%s', $id), $params, $opts);
    }
}