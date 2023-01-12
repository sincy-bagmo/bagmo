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


class InstrumentHelper
{

    public static function getTrayImageFromFile($filename = null, $path = '')
    {
        $file = asset('images/default-tray.png');
        if (! is_null($filename)) {
            if (FileManager::checkFileExist($filename, $path)) {
                $file = FileManager::getFileUrl($filename, $path);
            }
        }
        return $file;
    }

    public static function getImageFromFile($filename = null, $path = '')
    {
        $file = asset('images/default-user.png');
        if (! is_null($filename)) {
            if (FileManager::checkFileExist($filename, $path)) {
                $file = FileManager::getFileUrl($filename, $path);
            }
        }
        return $file;
    }

    public static function getInstrumentsInCategoryCount($categoryId)
    {
        return InstrumentItems::where('category_id', $categoryId)->count();
    }

    public static function getInstrumentsInTrayCount($trayId)
    {
        return TrayInstruments::where('tray_id', $trayId)->count();
    }

    public static function getTrayForOperationCount($operationId)
    {
        return OperationTrays::where('operation_id', $operationId)->count();
    }

    public static function getTraysInTrayCategoryCount($categoryId)
    {
        return Trays::where('tray_category_id', $categoryId)->count();
    }

    public function getInstrumentsInStock($categoryId)
    {
        return InstrumentItems::where('in_stock', OrderConstants::STOCK_AVAILABLE)->where('category_id', $categoryId)->get();
    }

    public function getTrayToWhichInstrumentIsAdded($instrumentId)
    {
        $tray = DB::table(TrayInstruments::getTableName().' as ti')
            ->join(Trays::getTableName().' as t','t.id', 'ti.tray_id')
            ->where('ti.instrument_item_id', $instrumentId)
            ->pluck('t.tray_name')->toArray();
        return $tray[0] ?? '----';
    }

}
