<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class Tax_Rate_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of your tax rates. Tax rates are returned sorted by creation
     * date, with the most recently created tax rates appearing first.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\TaxRate>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/tax_rates', $params, $opts);
    }
    /**
     * Creates a new tax rate.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\TaxRate
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/tax_rates', $params, $opts);
    }
    /**
     * Retrieves a tax rate with the given ID.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\TaxRate
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/tax_rates/%s', $id), $params, $opts);
    }
    /**
     * Updates an existing tax rate.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\TaxRate
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->build_path('/v1/tax_rates/%s', $id), $params, $opts);
    }
}