<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Treasury;

class Received_Credit_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of ReceivedCredits.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Treasury\ReceivedCredit>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/treasury/received_credits', $params, $opts);
    }
    /**
     * Retrieves the details of an existing ReceivedCredit by passing the unique
     * ReceivedCredit ID from the ReceivedCredit list.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Treasury\ReceivedCredit
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/treasury/received_credits/%s', $id), $params, $opts);
    }
}