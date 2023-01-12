<?php
/**
 * User constants
 */

namespace App\Http\Constants;


class UserConstants
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_ARCHIVED = 2;

    const STATUS = [
        self::STATUS_INACTIVE => 'InActive',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_ARCHIVED => 'Archived',
    ];

    const USER_TYPE_CSSD_ADMIN = 0;
    const USER_TYPE_OT = 1;
    const USER_TYPE_WASHING = 2;
    const USER_TYPE_STERILIZATION = 3;
    const USER_TYPE_PACKING = 4;
    const USER_TYPE_COLLECTION = 5;


    const USER_TYPES = [
        self::USER_TYPE_CSSD_ADMIN => 'CSSD User',
        self::USER_TYPE_OT => 'OT User',
        self::USER_TYPE_WASHING => 'Washed User',
        self::USER_TYPE_STERILIZATION => 'Sterilized User',
        self::USER_TYPE_PACKING => 'Packing User',
        self::USER_TYPE_COLLECTION => 'Collection User',
    ];

    const STERILIZATION_USER_TYPE = [
        self::USER_TYPE_WASHING => 'Washed user',
        self::USER_TYPE_STERILIZATION => 'Sterilized user',
        self::USER_TYPE_PACKING => 'Packing user',
    ];

}

