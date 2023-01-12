<?php

/**
 * Notification Constants
 */

namespace App\Http\Constants;


class NotificationConstants
{

    const PAGINATION_LIMIT = 10;
    const NOTIFICATION_NOT_SEEN = 0;
    const NOTIFICATION_SEEN = 1;

    const NOTIFICATION = [
        self::NOTIFICATION_NOT_SEEN => 'not seen',
        self::NOTIFICATION_SEEN => 'seen',
    ];
}
