<?php
/**
 * User constants
 */

namespace App\Http\Constants;


class InventoryConstants
{
    const CATEGORY_TYPE_CONSUMABLE = 0;
    const CATEGORY_TYPE_IN_TRAY = 1;
    const CATEGORY_TYPE_PEEL_PACK = 2;
    const CATEGORY_TYPE_DISPOSABLE = 3;
    const CATEGORY_TYPE = [
        self::CATEGORY_TYPE_CONSUMABLE => 'Consumables',
        self::CATEGORY_TYPE_IN_TRAY => 'In Tray',
        self::CATEGORY_TYPE_PEEL_PACK => 'Peel Pack',
        self::CATEGORY_TYPE_DISPOSABLE => 'Disposable',
    ];

    const CATEGORY_RETURNABLE_NO = 0;
    const CATEGORY_RETURNABLE_YES = 1;
    const CATEGORY_RETURNABLE = [
        self::CATEGORY_RETURNABLE_NO => 'No',
        self::CATEGORY_RETURNABLE_YES => 'Yes',
    ];

    const WASHABLE_NO = 0;
    const WASHABLE_YES = 1;
    const WASHABLE = [
        self::CATEGORY_RETURNABLE_NO => 'No',
        self::CATEGORY_RETURNABLE_YES => 'Yes',
    ];

    const WASHABLE_NAMES = [
        self::CATEGORY_RETURNABLE_NO => 'Not Washable',
        self::CATEGORY_RETURNABLE_YES => 'Washable',
    ];

    const WASH_CYCLE_STATUS_WASH_TO_NOT = 0;
    const WASH_CYCLE_STATUS_WASH_TO_BE = 1;
    const WASH_CYCLE_STATUS = [
        self::WASH_CYCLE_STATUS_WASH_TO_NOT => 'Washed',
        self::WASH_CYCLE_STATUS_WASH_TO_BE => 'To Be Washed',
    ];

    
    const  INSTRUMENTS_MISSING_NO = 0;
    const INSTRUMENTS_MISSING_YES = 1;
    const INSTRUMENTS_MISSING = [
        self::INSTRUMENTS_MISSING_NO => 'No',
        self::INSTRUMENTS_MISSING_YES => 'Yes',
    ];

    const  INSTRUMENTS_DAMAGED_NO = 0;
    const INSTRUMENTS_DAMAGED_YES = 1;
    const INSTRUMENTS_DAMAGED = [
        self::INSTRUMENTS_DAMAGED_NO => 'No',
        self::INSTRUMENTS_DAMAGED_YES => 'Yes',
    ];

    const WASHER_STATUS_IN = 0;
    const WASHER_STATUS_OUT = 1;
    const WASHER_STATUS = [
        self::WASHER_STATUS_IN => 'In',
        self::WASHER_STATUS_OUT => 'Out',
    ];

}

