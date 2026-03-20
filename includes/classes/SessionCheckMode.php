<?php

declare(strict_types=1);
/*
  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

/**
 * SessionCheckMode — backed string enum for session security check configuration constants.
 *
 * Phoenix configuration constants such as SESSION_CHECK_IP_ADDRESS,
 * SESSION_CHECK_USER_AGENT, and SESSION_CHECK_SSL_SESSION_ID are stored in the
 * database as the strings 'True' or 'False'.
 *
 * This enum provides type-safe wrappers for those string values, replacing
 * comparisons like:
 *   if (SESSION_CHECK_IP_ADDRESS === 'True') { ... }
 *
 * With:
 *   if (SessionCheckMode::from(SESSION_CHECK_IP_ADDRESS)->isEnabled()) { ... }
 *
 * @since 1.1.0
 */
enum SessionCheckMode: string
{
    /** The session security check is active. */
    case Enabled = 'True';

    /** The session security check is inactive. */
    case Disabled = 'False';

    /**
     * Returns whether this mode means the check is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this === self::Enabled;
    }
}
