<?php
/**
 * Order constants
 */

namespace App\Http\Constants;


class OrderConstants
{
    const STATUS_ORDER_PLACED = 0;
    const STATUS_ISSUED_TO_OT_USER = 1;
    const STATUS_RETURNED_FROM_OT_USER = 2;
    const STATUS_RECEIVED_AT_COLLECTION_USER = 3;
    const STATUS_RETURNED_FROM_COLLECTION_USER = 4;
    const STATUS_RECEIVED_AT_WASH = 5;
    const STATUS_RETURNED_FROM_WASH_USER = 6;
    const STATUS_RECEIVED_AT_PACKING = 7;
    const STATUS_RETURNED_FROM_PACKING_USER = 8;
    const STATUS_RECEIVED_AT_STERILIZATION = 9;
    const STATUS_RETURNED_FROM_STERILIZATION_USER = 10;

    const STATUS = [
        self::STATUS_ORDER_PLACED => 'Order Placed',
        self::STATUS_ISSUED_TO_OT_USER => 'Issued to OT',
        self::STATUS_RETURNED_FROM_OT_USER => 'Returned From OT',
        self::STATUS_RECEIVED_AT_COLLECTION_USER => 'Received At Collection User',
        self::STATUS_RETURNED_FROM_COLLECTION_USER => 'Returned From Collection User',
        self::STATUS_RECEIVED_AT_WASH => 'Received at Wash',
        self::STATUS_RETURNED_FROM_WASH_USER => 'Returned From Wash',
        self::STATUS_RECEIVED_AT_PACKING => 'Received at Packing',
        self::STATUS_RETURNED_FROM_PACKING_USER => 'Returned From Packing',
        self::STATUS_RECEIVED_AT_STERILIZATION => 'Received At Sterilization',
        self::STATUS_RETURNED_FROM_STERILIZATION_USER => 'Returned Back To Rack',
    ];

    const STOCK_AVAILABLE = 0;
    const STOCK_NOT_AVAILABLE = 1;
    const STOCK_STATUS = [
        self::STOCK_AVAILABLE => 'In Stock',
        self::STOCK_NOT_AVAILABLE => 'Out Of Stock',
    ];

    const ORDER_ITEM_STATUS_NOT_ALLOCATED = 0;
    const ORDER_ITEM_STATUS_ALLOCATED = 1;
    const ORDER_ITEM_STATUS = [
        self::ORDER_ITEM_STATUS_NOT_ALLOCATED => 'Not Allocated',
        self::ORDER_ITEM_STATUS_ALLOCATED,
    ];

    // Order Process
    const ORDERS_REQUESTED = [
        self::STATUS_ORDER_PLACED
    ];
    const ORDERS_IN_OT_PROCESS = [
        self::STATUS_ISSUED_TO_OT_USER,
    ];

    const ORDERS_IN_STERILIZATION_PROCESS = [
        self::STATUS_RETURNED_FROM_OT_USER,
        self::STATUS_RECEIVED_AT_COLLECTION_USER,
        self::STATUS_RETURNED_FROM_COLLECTION_USER,
        self::STATUS_RECEIVED_AT_WASH,
        self::STATUS_RETURNED_FROM_WASH_USER,
        self::STATUS_RECEIVED_AT_PACKING,
        self::STATUS_RETURNED_FROM_PACKING_USER,
        self::STATUS_RECEIVED_AT_STERILIZATION,
        self::STATUS_RETURNED_FROM_STERILIZATION_USER,
    ];

    const ORDERS_RETURNED_BACK_FROM_OT = [
        self::STATUS_RETURNED_FROM_OT_USER,
        self::STATUS_RECEIVED_AT_COLLECTION_USER,
        self::STATUS_RETURNED_FROM_COLLECTION_USER,
        self::STATUS_RECEIVED_AT_WASH,
        self::STATUS_RETURNED_FROM_WASH_USER,
        self::STATUS_RECEIVED_AT_PACKING,
        self::STATUS_RETURNED_FROM_PACKING_USER,
        self::STATUS_RECEIVED_AT_STERILIZATION,
        self::STATUS_RETURNED_FROM_STERILIZATION_USER,
    ];

    const ORDER_MISSING_ADDED_BY_OT_USER = 0;
    const ORDER_MISSING_ADDED_BY_STERILIZATION_USER = 1;

    const WASHER_IN = 0;
    const WASHER_OUT = 1;
}

