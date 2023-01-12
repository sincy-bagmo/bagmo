<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodBag extends Model
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
        'blood_bag_name',
        'type',
        'blood_group',
        'product_id',
        'volume',
        'expiry_date',
        'status',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

}
