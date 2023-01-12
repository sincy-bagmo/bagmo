<?php


namespace App\Http\Helpers;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\FileDestinations;
use App\Http\Constants\OrderConstants;
use App\Http\Constants\UserConstants;
use App\Http\Helpers\Core\DateHelper;
use App\Http\Helpers\Core\FileManager;
use App\Models\Categories;
use App\Models\InstrumentItems;
use App\Models\OperationTrays;
use App\Models\TrayInstruments;
use App\Models\Trays;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BloodBagHelper
{

    public static function getBloodBagImageFromFile($filename = null, $path = '')
    {
        $file = asset('images/bloodBag.jpg');
        if (! is_null($filename)) {
            if (FileManager::checkFileExist($filename, $path)) {
                $file = FileManager::getFileUrl($filename, $path);
            }
        }
        return $file;
    }

}
