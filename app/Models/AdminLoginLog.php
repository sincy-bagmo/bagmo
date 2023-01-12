<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLoginLog extends Model
{
    use HasFactory;

    protected $table = 'admin_login_logs';

    protected $fillable = [
        'admin_id',
        'status',
        'logged_at',
        'remote_address',
        'note',
        'header',
    ];

    public $timestamps = false;

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
