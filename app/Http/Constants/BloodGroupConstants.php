<?php

namespace App\Http\Constants;

class BloodGroupConstants
{
    const BLOOD_GROUP_UNKNOWN = 1;
    const BLOOD_GROUP_A_POSITIVE = 2;
    const BLOOD_GROUP_A_NEGATIVE = 3;
    const BLOOD_GROUP_B_POSITIVE = 4;
    const BLOOD_GROUP_B_NEGATIVE = 5;
    const BLOOD_GROUP_AB_POSITIVE = 6;
    const BLOOD_GROUP_AB_NEGATIVE = 7;
    const BLOOD_GROUP_O_POSITIVE = 8;
    const BLOOD_GROUP_O_NEGATIVE = 9;

   
    
    const BLOOD_GROUP = [
        self::BLOOD_GROUP_UNKNOWN => 'Unknown',
        self::BLOOD_GROUP_A_POSITIVE => 'A Positive',
        self::BLOOD_GROUP_A_NEGATIVE => 'A Negative',
        self::BLOOD_GROUP_B_POSITIVE => 'B Positive',
        self::BLOOD_GROUP_B_NEGATIVE => 'B Negative',
        self::BLOOD_GROUP_AB_POSITIVE => 'AB Positive',
        self::BLOOD_GROUP_AB_NEGATIVE => 'AB Negative',
        self::BLOOD_GROUP_O_POSITIVE => 'O Positive',
        self::BLOOD_GROUP_O_NEGATIVE => 'O Negative',
    ];

    // Component Types
    const TYPE_PRC = 1;
    const TYPE_PC = 2;
    const TYPE_FFP = 3;
    const TYPE_CRYO = 4;
    const TYPE_CPP = 5;
    const TYPE_WHOLE_BLOOD = 6;
    const TYPE = [
        self::TYPE_PRC => 'PRC',
        self::TYPE_PC => 'PC',
        self::TYPE_FFP => 'FFP',
        self::TYPE_CRYO => 'CRYO',
        self::TYPE_CPP => 'CPP',
        self::TYPE_WHOLE_BLOOD => 'WHOLE BLOOD',
    ];

    const BLOOD_BAG_STATUS_OUT = 0;
    const BLOOD_BAG_STATUS_IN = 1;
    const BLOOD_BAG_STATUS = [
        self::BLOOD_BAG_STATUS_OUT => 'Out',
        self::BLOOD_BAG_STATUS_IN => 'In',
    ];
}
