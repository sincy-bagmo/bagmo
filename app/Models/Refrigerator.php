<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refrigerator extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'refrigerator_name',
        'type',
        'reference_number',
        'company',
        'indication_name',
        'remarks',
        'barcode',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

}
