<?php
/**
 * washInventory constants
 */

namespace App\Http\Constants;


class WashInventoryConstants
{
    const STATUS_ORDER_PLACED = 0;
    const STATUS_ORDER_ISSUED = 1;
    const STATUS_RECEIVED_AT_COLLECTION_USER = 2;
    const STATUS_RETURNED_FROM_COLLECTION_USER = 3;
    const STATUS_RECEIVED_AT_WASH = 4;
    const STATUS_RETURNED_FROM_WASH_USER = 5;
    const STATUS_RECEIVED_AT_PACKING = 6;
    const STATUS_RETURNED_FROM_PACKING_USER = 7;
    const STATUS_RECEIVED_AT_STERILIZATION = 8;
    const STATUS_RETURNED_FROM_STERILIZATION_USER = 9;

    const WASH_STATUS = [
        self::STATUS_ORDER_PLACED => 'Order Placed',
        self::STATUS_ORDER_ISSUED => 'Order Issued',
        self::STATUS_RECEIVED_AT_COLLECTION_USER => 'Received At Collection User',
        self::STATUS_RETURNED_FROM_COLLECTION_USER => 'Returned From Collection User',
        self::STATUS_RECEIVED_AT_WASH => 'Received at Wash',
        self::STATUS_RETURNED_FROM_WASH_USER => 'Returned From Wash',
        self::STATUS_RECEIVED_AT_PACKING => 'Received at Packing',
        self::STATUS_RETURNED_FROM_PACKING_USER => 'Returned From Packing',
        self::STATUS_RECEIVED_AT_STERILIZATION => 'Received At Sterilization',
        self::STATUS_RETURNED_FROM_STERILIZATION_USER => 'Returned Back To Rack',
    ];

   
}

