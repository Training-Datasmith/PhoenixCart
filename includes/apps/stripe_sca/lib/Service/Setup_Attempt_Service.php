<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class Setup_Attempt_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of SetupAttempts associated with a provided SetupIntent.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\SetupAttempt>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/setup_attempts', $params, $opts);
    }
}