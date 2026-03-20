<?php

declare (strict_types=1);
// File generated from our OpenAPI spec
namespace Stripe\Service\Identity;

/**
 * Service factory class for API resources in the Identity namespace.
 *
 * @property VerificationReportService $verificationReports
 * @property VerificationSessionService $verificationSessions
 */
class Identity_Service_Factory extends \Stripe\Service\Abstract_Service_Factory
{
    /**
     * @var array<string, string>
     */
    private static array $class_map = ['verificationReports' => Verification_Report_Service::class, 'verificationSessions' => Verification_Session_Service::class];
    protected function get_service_class($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}