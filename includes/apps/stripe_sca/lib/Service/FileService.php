<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service;

class File_Service extends \Stripe\Service\Abstract_Service
{
    /**
     * Returns a list of the files that your account has access to. The files are
     * returned sorted by creation date, with the most recently created files appearing
     * first.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\File>
     */
    public function all($params = null, $opts = null)
    {
        return $this->request_collection('get', '/v1/files', $params, $opts);
    }
    /**
     * Retrieves the details of an existing file object. Supply the unique file ID from
     * a file, and Stripe will return the corresponding file object. To access file
     * contents, see the <a href="/docs/file-upload#download-file-contents">File Upload
     * Guide</a>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\File
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->build_path('/v1/files/%s', $id), $params, $opts);
    }
    /**
     * Create a file.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @return \Stripe\File
     */
    public function create($params = null, $opts = null)
    {
        $opts = \Stripe\Util\Request_Options::parse($opts);
        if (!isset($opts->api_base)) {
            $opts->api_base = $this->get_client()->get_files_base();
        }
        // Manually flatten params, otherwise curl's multipart encoder will
        // choke on nested null|arrays.
        $flat_params = \array_column(\Stripe\Util\Util::flatten_params($params), 1, 0);
        return $this->request('post', '/v1/files', $flat_params, $opts);
    }
}