<?php


namespace App\Services;

use App\Http\Constants\InventoryConstants;
use App\Models\Categories;
use App\Models\InstrumentItems;
use App\Models\LookupDepartments;
use App\Models\Notification;
use App\Models\OperationTrays;
use App\Models\TrayInstruments;
use App\Models\Trays;
use Illuminate\Support\Carbon;
use App\Http\Constants\NotificationConstants;
use App\Http\Constants\OrderConstants;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\TrayCategory;
use App\Models\TrayCategoryInstrument;
use Illuminate\Support\Facades\DB;


class InstrumentService
{

    /**
     * Get trays and items added for an operation
     *
     * @param $operationId
     * @return array
     */
    public function getTraysAddedForAnOperation($operationId)
    {
        $traysLinkedData = [];
        $linkedData = DB::table(OperationTrays::getTableName().' as ot')
            ->join(Trays::getTableName().' as t','t.id', 'ot.tray_id')
            ->join(LookupDepartments::getTableName().' as d','d.id', 't.department_id')
            ->select('t.id', 't.tray_name', 't.barcode', 't.weight', 't.wash_cycle', 't.last_wash_cycle', 't.tray_category_id', 't.created_at',
                'd.department_name')
            ->where('ot.operation_id', $operationId)
            ->whereNull('t.deleted_at')
            ->orderbyDesc('ot.created_at')
            ->get();
        foreach ($linkedData as $item) {
            $traysLinkedData[$item->id]['tray_details'] = $item;
            $traysLinkedData[$item->id]['items'] = DB::table(TrayInstruments::getTableName().' as ti')
                ->join(InstrumentItems::getTableName().' as i','i.id', 'ti.instrument_item_id')
                ->join(Categories::getTableName().' as c', 'c.id', 'i.category_id')
                ->select('i.id', 'c.category_name', 'c.weight', 'i.barcode', 'c.image', 'i.expiry', 'i.last_wash_cycle', 'i.category_id',
                        'c.returnable')
                ->where('ti.tray_id', $item->id)
                ->whereNull('i.deleted_at')
                ->orderbyDesc('ti.created_at')->get();
        }
        return $traysLinkedData;
    }


    public function getTrayCategoryAddedForAnOperation($operationId)
    {
        $trayCategory = [];
        $trayCategories = DB::table(OperationTrays::getTableName() . ' as ot')
            ->join(TrayCategory::getTableName() . ' as tc', 'tc.id', '=', 'ot.tray_category_id')
            ->where('operation_id', $operationId)->select('ot.tray_category_id', 'tc.category_name')
            ->get()->toArray(); 
        foreach ($trayCategories as $item) { 
        $trayCategory[$item->tray_category_id]['TrayCategory'] = $item;
        $trayCategory[$item->tray_category_id]['LinkedData'] =  DB::table(TrayCategoryInstrument::getTableName() . ' as ti')
            ->join(Categories::getTableName() . ' as c', 'c.id', '=', 'ti.category_id')
            ->select('c.id', 'ti.qty', 'c.category_name', 'ti.tray_category_id')
            ->where('ti.tray_category_id',  $item->tray_category_id)
            ->get();
        }
        return $trayCategory; 
    }
    

    /**
     * Get tray details and items added
     *
     * @param $trayId
     * @return array
     */
    public function getTraysDetails($trayId)
    {
        $traysLinkedData = [];
        if ($trayId > 0) {
            $linkedData = DB::table(Trays::getTableName() . ' as t')
                ->join(LookupDepartments::getTableName() . ' as d', 'd.id', 't.department_id')
                ->select('t.id', 't.tray_name', 't.barcode', 't.weight', 't.wash_cycle', 't.last_wash_cycle', 't.tray_category_id', 't.created_at',
                    'd.department_name')
                ->where('t.id', $trayId)
                ->whereNull('t.deleted_at')
                ->orderbyDesc('t.created_at')
                ->first();
            if (!is_null($linkedData)) {
                $traysLinkedData['tray_details'] = $linkedData;
                $traysLinkedData['items'] = DB::table(TrayInstruments::getTableName() . ' as ti')
                    ->join(InstrumentItems::getTableName() . ' as i', 'i.id', 'ti.instrument_item_id')
                    ->join(Categories::getTableName() . ' as c', 'c.id', 'i.category_id')
                    ->select('i.id', 'c.category_name', 'c.weight', 'i.barcode', 'c.image', 'i.expiry', 'i.last_wash_cycle', 'i.category_id',
                        'c.returnable')
                    ->where('ti.tray_id', $linkedData->id)
                    ->whereNull('i.deleted_at')
                    ->orderbyDesc('ti.created_at')->get();
            }
        }
        return $traysLinkedData;
    }

    public function getAddittionalInstrumentInOrder($orderId)
    {
        return DB::table(OrderItems::getTableName() . ' as oi')
            ->join(Categories::getTableName() . ' as c', 'c.id', 'oi.instrument_category_id')
            ->select('c.id', 'c.category_name', 'oi.qty', 'c.code', DB::raw("SUM(oi.qty) as total"))
            ->where('order_id', $orderId)->whereNull('tray_id')
            ->groupBy('c.id', 'c.category_name', 'oi.qty', 'c.code')->get();
    }

    public function getAddOnTraysDetailsFromCategory($trayCategoryIds = [])
    {
        $traysLinkedData = [];
        if (! empty($trayCategoryIds)) {
            foreach ($trayCategoryIds as $categoryId) {
                $traysLinkedData[] = $this->getTrayDetailsOfNotAssignedToOperations($categoryId);
            }
        }
        return $traysLinkedData;
    }

    public function getAddOnTrayCategoryDetailsFromCategory($trayCategoryIds = [], $trayId)
    {
        $traysLinkedData = [];
        if (! empty($trayCategoryIds)) {
            foreach ($trayCategoryIds as $categoryId) {
                $traysLinkedData[] = $this->getTrayDetailsOfNotAssignedToOperation($categoryId, $trayId);
            }
        }
        return $traysLinkedData;    
    }

    public function getAdditionalTraysNotInOperations($operationId)
    {
        $traysCollection = Trays::pluck('id')->toArray();
        $linkedData = DB::table(OperationTrays::getTableName().' as ot')
            ->join(Trays::getTableName().' as t','t.id', 'ot.tray_id')
            ->where('ot.operation_id', $operationId)
            ->whereNull('t.deleted_at')
            ->pluck('t.id')->toArray();
        $remainingTrayIds = array_diff($traysCollection, $linkedData);
        return Trays::whereIn('id', $remainingTrayIds)->pluck('tray_name', 'id');
    }

    public function getCategoryDetailsCollection($instrumentCategoryIds = [])
    {
        return (! empty($instrumentCategoryIds)) ? Categories::whereIn('id', $instrumentCategoryIds)->get() : [];
    }

    public function getInstrumentCategoryNotAssignedToTray($trayId = 0)
    {
        $instrumentItems = InstrumentItems::pluck('id')->toArray();
        if ($trayId > 0) {
            $linkedInstruments = TrayInstruments::where('tray_id', $trayId)->pluck('instrument_item_id')->toArray();
        } else {
            $linkedInstruments = TrayInstruments::pluck('instrument_item_id')->toArray();
        }
        $remainingInstrumentsId = array_diff($instrumentItems, $linkedInstruments);
        return DB::table(InstrumentItems::getTableName().' as i')
            ->join(Categories::getTableName().' as c','c.id', 'i.category_id')
            ->whereIn('i.id', $remainingInstrumentsId)
            ->groupBy('c.id')
            ->pluck('c.category_name', 'c.id');
    }

    public function getTrayDetailsOfNotAssignedToOperations($trayCategoryId)
    {
        $traysIdsInCategory = Trays::where('tray_category_id', $trayCategoryId)->pluck('id')->toArray();
        $traysAddedInOtherOperations = OperationTrays::whereIn('tray_id', $traysIdsInCategory)->pluck('tray_id')->toArray();
        $traysAvailable = array_diff($traysIdsInCategory, $traysAddedInOtherOperations);
        $traySelected = (! empty($traysAvailable)) ? array_shift($traysAvailable) : 0;
        return $this->getTraysDetails($traySelected);
    }

    public function getTrayDetailsOfNotAssignedToOperation($trayCategoryId)
    {
        $trayCategory = [];
        $trayCategory['Category'] =TrayCategory::where('id', $trayCategoryId)->select('id', 'category_name')
        ->first(); 
        $trayCategory['LinkedData'] =  DB::table(TrayCategoryInstrument::getTableName() . ' as ti')
            ->join(Categories::getTableName() . ' as c', 'c.id', '=', 'ti.category_id')
            ->select('c.id', 'ti.qty', 'c.category_name', 'ti.tray_category_id')
            ->where('ti.tray_category_id',  $trayCategory['Category']->id)
            ->get();

        return $trayCategory;
    }


    public function getTrayCategoryDetailsOfNotAssignedToOperations($trayCategoryId)
    { 
        return DB::table(TrayCategoryInstrument::getTableName() . ' as ti', 'ti.tray_category_id', '=', 'tc.id')
            ->join(Categories::getTableName() . ' as c', 'c.id', '=', 'ti.category_id')
            ->select('ti.qty', 'c.category_name', 'c.weight')
            ->where('ti.tray_category_id', $trayCategoryId)
            ->get();
    }
 
    

}
