<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class Country_Spec_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Lists all Country Spec objects available in the API.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\CountrySpec>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/country_specs', $params, $opts);
    }
    /**
     * Returns a Country Spec for a given Country code.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\CountrySpec
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/country_specs/%s', $id), $params, $opts);
    }
}