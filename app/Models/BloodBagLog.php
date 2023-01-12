<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodBagLog extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'refrigerator_id',
        'storage_rack_id',
        'blood_bag_id',
        'scan_in',
        'scan_in_user',
        'scan_out',
        'scan_out_user',
        'status',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

}
