<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Apps;

class Secret_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * List all secrets stored on the given scope.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Apps\Secret>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/apps/secrets', $params, $opts);
    }
    /**
     * Create or replace a secret in the secret store.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Apps\Secret
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/apps/secrets', $params, $opts);
    }
    /**
     * Deletes a secret from the secret store by name and scope.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Apps\Secret
     */
    public function delete_where($params = null, $opts = null)
    {
        return $this->request('post', '/v1/apps/secrets/delete', $params, $opts);
    }
    /**
     * Finds a secret in the secret store by name and scope.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Apps\Secret
     */
    public function find($params = null, $opts = null)
    {
        return $this->request('get', '/v1/apps/secrets/find', $params, $opts);
    }
}