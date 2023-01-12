<?php


namespace App\Services;

use App\Http\Constants\OrderConstants;
use App\Models\Categories;
use App\Models\InstrumentItems;
use App\Models\LookupDepartments;
use App\Models\Operations;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\TrayInstruments;
use App\Models\Trays;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Http\Constants\NotificationConstants;
use App\Models\OperationTrays;
use App\Models\TrayCategory;
use App\Models\TrayCategoryInstrument;
use Illuminate\Support\Facades\DB;


class OrderManagementService
{

    public function getOrderRequest()
    {
        return DB::table(Orders::getTableName().' as o')
            ->join(Operations::getTableName().' as s', 's.id', '=','o.operation_id')
            ->join(User::getTableName().' as u', 'u.id', '=','o.user_id')
            ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.booking_date', 'o.description', 'o.status', 'o.created_at',
                            's.operation_name', 'u.ot_name')
            ->where('o.status', OrderConstants::STATUS_ORDER_PLACED)
            ->orderByDesc('o.created_at')->get();
    }

   

    public function getTrayCategoryAddedForAnOperation($orderId)
    {
        $trayCategory = [];
        $trayCategories = DB::table(OrderItems::getTableName() . ' as oi')
            ->join(TrayCategory::getTableName() . ' as tc', 'tc.id', '=', 'oi.tray_category_id')
            ->select('oi.tray_category_id', 'tc.category_name', 'tc.image')
            ->where('oi.order_id', $orderId)
            ->get()->toArray(); 
        foreach ($trayCategories as $item) { 
        $trayCategory[$item->tray_category_id]['TrayCategory'] = $item;
        $trayCategory[$item->tray_category_id]['LinkedData'] =  DB::table(TrayCategoryInstrument::getTableName() . ' as ti')
            ->join(Categories::getTableName() . ' as c', 'c.id', '=', 'ti.category_id')
            ->select('c.id', 'ti.qty', 'c.category_name', 'ti.tray_category_id')
            ->where('ti.tray_category_id',  $item->tray_category_id)
            ->get();
        $trayCategory[$item->tray_category_id]['TrayDetails'] = Trays::where('in_stock', OrderConstants::STOCK_AVAILABLE)
            ->where('tray_category_id', $item->tray_category_id)
            ->pluck('tray_name', 'id');
        }
        return $trayCategory; 
    }

    public function getTrayCategoryAddedInOrder($orderId)
    {
        $trayCategory = [];
        $trayCategory = DB::table(OrderItems::getTableName() . ' as oi')
            ->join(TrayCategory::getTableName() . ' as tc', 'tc.id', '=', 'oi.tray_category_id')
            ->select('oi.tray_category_id', 'tc.category_name', 'tc.image')
            ->where('oi.order_id', $orderId)
            ->get()->toArray(); 
            foreach ($trayCategory as $key => $item) {
                $trayCategory[$key]->trays = Trays::where('in_stock', OrderConstants::STOCK_AVAILABLE)
                ->where('tray_category_id', $item->tray_category_id)
                ->pluck('tray_name', 'barcode');
            }
        return $trayCategory; 
    }


    public function getCategoryDetailsCollection($instrumentCategoryIds = [])
    {
        return (! empty($instrumentCategoryIds)) ? Categories::whereIn('id', $instrumentCategoryIds)->get() : [];
    }

   

    public function getTraysAndAdditionalInventory($operationId)
    {
        $traysLinkedData = [];
        $linkedData = DB::table(OrderItems::getTableName().' as oi')
            ->join(Orders::getTableName().' as o', 'o.id', '=', 'oi.order_id')
            ->join(Trays::getTableName().' as t','t.id', 'oi.tray_id')
            ->join(LookupDepartments::getTableName().' as d','d.id', 't.department_id')
            ->select('t.id', 't.tray_name', 't.barcode', 't.weight', 't.wash_cycle', 't.last_wash_cycle', 't.created_at', 't.image', 't.in_stock',
                'd.department_name', 'oi.qty')
            ->where('o.operation_id', $operationId)
            ->whereNull('t.deleted_at')
            ->orderbyDesc('oi.created_at')
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

                $traysLinkedData[$item->id]['tray_details']->instrumentWeight = DB::table(TrayInstruments::getTableName().' as ti')
                ->join(InstrumentItems::getTableName().' as i','i.id', 'ti.instrument_item_id')
                ->join(Categories::getTableName().' as c', 'c.id', 'i.category_id')
                ->where('ti.tray_id', $item->id)
                ->whereNull('i.deleted_at')->sum('c.weight');
        }
        return $traysLinkedData;
    }

    public function getTrayAndAdditionalInventory($orderId)
    {
        $traysLinkedData = [];
        $linkedData = DB::table(OrderItems::getTableName().' as oi')
            ->join(Orders::getTableName().' as o', 'o.id', '=', 'oi.order_id')
            ->join(Trays::getTableName().' as t','t.id', 'oi.tray_id')
            ->join(LookupDepartments::getTableName().' as d','d.id', 't.department_id')
            ->select('t.id', 't.tray_name', 't.barcode', 't.weight', 't.wash_cycle', 't.last_wash_cycle', 't.created_at', 't.image', 't.in_stock',
                'd.department_name', 'oi.qty')
            ->where('oi.order_id', $orderId)
            ->whereNull('t.deleted_at')
            ->orderbyDesc('oi.created_at')
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

                $traysLinkedData[$item->id]['tray_details']->instrumentWeight = DB::table(TrayInstruments::getTableName().' as ti')
                ->join(InstrumentItems::getTableName().' as i','i.id', 'ti.instrument_item_id')
                ->join(Categories::getTableName().' as c', 'c.id', 'i.category_id')
                ->where('ti.tray_id', $item->id)
                ->whereNull('i.deleted_at')->sum('c.weight');
        }
        return $traysLinkedData;
    }


    public function getAddOnInstruments($orderId)
    {
        return DB::table(OrderItems::getTableName().' as oi')
            ->join(Categories::getTableName().' as c', 'c.id', '=', 'oi.instrument_category_id')
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
            ->select('c.category_name', DB::raw('SUM(oi.qty) as qty'), 'c.image', 'c.returnable')
            ->groupBy('c.category_name', 'c.image', 'c.returnable')
            ->get();
    }

    public function getAddonInstrumentsRequestedForOrder($orderId)
    {
        return DB::table(OrderItems::getTableName().' as oi')
            ->join(Categories::getTableName().' as c', 'c.id', '=', 'oi.instrument_category_id')
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
            ->pluck('c.category_name', 'c.id')->toArray();
    }

    public function getAddonInstrumentsRequestedForOrderStockStatus($orderId)
    {
        $addOnInstruments =  DB::table(OrderItems::getTableName().' as oi')
            ->join(Categories::getTableName().' as c', 'c.id', '=', 'oi.instrument_category_id')
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
            ->select('c.id', DB::raw('count(c.id) as count'))
            ->groupBy('c.id')
            ->get();
        $instrumentCategoryStatus = [];
        $totalInstrumentStockStatus =  OrderConstants::STOCK_AVAILABLE;
        foreach ($addOnInstruments as $addOnInstrumentCategory) {
            $instrumentCount = InstrumentItems::where('category_id', $addOnInstrumentCategory->id)->where('in_stock', OrderConstants::STOCK_AVAILABLE)->count();
            $stockStatus = ($instrumentCount >= $addOnInstrumentCategory->count)?  OrderConstants::STOCK_AVAILABLE :  OrderConstants::STOCK_NOT_AVAILABLE;
            $instrumentCategoryStatus[$addOnInstrumentCategory->id] = $stockStatus;
            if (OrderConstants::STOCK_NOT_AVAILABLE == $stockStatus) {
                $totalInstrumentStockStatus =  OrderConstants::STOCK_NOT_AVAILABLE;
            }
        }
        return ['totalStatus' => $totalInstrumentStockStatus, 'individualStatus' => $instrumentCategoryStatus];
    }

    public function getAddonInstrumentsRequestedForOrderSuggestions($orderId)
    {
        $addOnInstruments =  DB::table(OrderItems::getTableName().' as oi')
            ->join(Categories::getTableName().' as c', 'c.id', '=', 'oi.instrument_category_id')
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
            ->select('c.id', DB::raw('count(c.id) as count'), 'c.category_name', 'c.weight')
            ->groupBy('c.id', 'c.category_name')
            ->get();

        $finalSuggestions = [];
        foreach ($addOnInstruments as $addOnInstrumentCategory) {
            $instruments = DB::table(InstrumentItems::getTableName().' as i')
                    ->leftJoin(TrayInstruments::getTableName().' as ti', 'i.id', 'ti.instrument_item_id')
                    ->select('i.id', 'i.category_id', 'i.barcode', 'ti.instrument_item_id')
                    ->where('i.category_id', $addOnInstrumentCategory->id)
                    ->where('i.in_stock', OrderConstants::STOCK_AVAILABLE)
                    ->whereNull('ti.instrument_item_id')
                    ->limit($addOnInstrumentCategory->count)
                    ->get()->toArray();

            for ($i = 0; $i < $addOnInstrumentCategory->count; $i++) {
                $finalSuggestions[$addOnInstrumentCategory->id][] = [
                    'category_id' => $addOnInstrumentCategory->id,
                    'category_name' => $addOnInstrumentCategory->category_name,
                    'weight' =>  $addOnInstrumentCategory->weight,
                    'instrument_id' => isset($instruments[$i]) ? $instruments[$i]->id : 0,
                    'barcode' => isset($instruments[$i]) ? $instruments[$i]->barcode : '-----',
                ];
            }
        }
        return $finalSuggestions;
    }

    public function getTrayWeight($trayDetails)
    {
        $totalWeightForTrays = 0;
        $trayWeight = [];
        $stockStatus = OrderConstants::STOCK_AVAILABLE;
        foreach ($trayDetails as $tray) {
            $trayWeight[$tray['tray_details']->id] = $tray['tray_details']->weight;
            $totalWeightForTrays += $tray['tray_details']->weight;
            if (OrderConstants::STOCK_NOT_AVAILABLE == $tray['tray_details']->in_stock) {
                $stockStatus = $tray['tray_details']->in_stock;
            }
            foreach ($tray['items'] as $trayInstrument) {
                $totalWeightForTrays += $trayInstrument->weight;
                $trayWeight[$tray['tray_details']->id] += $trayInstrument->weight;
            }
        }
        return ['totalWeight' => $totalWeightForTrays, 'individualWeight' => $trayWeight, 'stockStatus' => $stockStatus];
    }

    public function getInstruments($orderId)
    {
        return DB::table(OrderItems::getTableName().' as oi')
            ->join(Categories::getTableName().' as c', 'c.id', '=', 'oi.instrument_category_id')
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
            ->select('c.id', 'c.category_name', 'c.image', 'c.returnable',  'oi.id AS order_item_id')->get();
    }

    public function getAdditionalInstrumentsAddedToOrder($orderId)
    {
        return DB::table(OrderItems::getTableName().' as oi')
            ->join(Categories::getTableName().' as c', 'c.id', 'oi.instrument_category_id')
            ->select('c.id', 'c.category_name', 'c.type', 'c.image', 'oi.id AS order_item_id', 'c.returnable')
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
            ->where('oi.status', OrderConstants::ORDER_ITEM_STATUS_NOT_ALLOCATED)
            ->orderbyDesc('oi.created_at')
            ->get();
    }

    public function getIssuedOrderInstruments($orderId)
    {
        return DB::table(OrderItems::getTableName().' as oi')
            ->join(Categories::getTableName().' as c', 'c.id', '=', 'oi.instrument_category_id')
            ->join(InstrumentItems::getTableName().' as i', 'i.id', '=', 'oi.instrument_item_id')
            ->select('oi.instrument_category_id', 'oi.instrument_item_id', 'c.category_name', 'c.type', 'c.image', 'c.returnable',
                'c.code', 'i.barcode', 'i.expiry', 'c.weight')
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
            ->orderbyDesc('oi.created_at')
            ->get();
    }

    public function getInstrumentsInStock()
    {
        return InstrumentItems::where('in_stock', OrderConstants::STOCK_AVAILABLE)->get();
    }


}
