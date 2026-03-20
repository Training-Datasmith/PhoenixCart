<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Identity;

class Verification_Report_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * List all verification reports.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Identity\VerificationReport>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/identity/verification_reports', $params, $opts);
    }
    /**
     * Retrieves an existing VerificationReport.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Identity\VerificationReport
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/identity/verification_reports/%s', $id), $params, $opts);
    }
}