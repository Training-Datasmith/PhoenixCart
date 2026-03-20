<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Reporting;

class Report_Run_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of Report Runs, with the most recent appearing first.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\Reporting\ReportRun>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/reporting/report_runs', $params, $opts);
    }
    /**
     * Creates a new object and begin running the report. (Certain report types require
     * a <a href="https://stripe.com/docs/keys#test-live-modes">live-mode API key</a>.).
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Reporting\ReportRun
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/reporting/report_runs', $params, $opts);
    }
    /**
     * Retrieves the details of an existing Report Run.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Reporting\ReportRun
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/reporting/report_runs/%s', $id), $params, $opts);
    }
}