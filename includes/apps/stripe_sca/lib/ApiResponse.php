<?php

declare (strict_types=1);
namespace Stripe;

use Stripe\Util\Case_Insensitive_Array;
/**
 * Class ApiResponse.
 */
class Api_Response
{
    /**
     * @param string $body
     * @param int $code
     * @param null|array|CaseInsensitiveArray $headers
     * @param null|array $json
     */
    public function __construct(public $body, public $code, public $headers, public $json)
    {
    }
}