<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageRack extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'refrigerator_id',
        'rack_name',
        'rack_number',
        'rack_barcode',
        'description',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
