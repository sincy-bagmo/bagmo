<?php
/*
 * Breadcrumbs Helper
 *
 * @author Agin
 * @date 26-Oct-2018
 */

namespace App\Services\Admin;



use App\Http\Constants\OrderConstants;
use App\Http\Helpers\Core\DateHelper;
use App\Models\AdminLoginLog;
use App\Models\InstrumentItems;
use App\Models\Operations;
use App\Models\OperationTrays;
use App\Models\Orders;
use App\Models\TrayInstruments;
use App\Models\Trays;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class HomePageService
{

    public function getStatisticsOfOrders()
    {
        $instrumentItems = InstrumentItems::pluck('id')->toArray();
        $linkedInstruments = TrayInstruments::pluck('instrument_item_id')->toArray();
        $remainingInstrumentsId = array_diff($instrumentItems, $linkedInstruments);
        return [
            'traysAvailable' => Trays::where('in_stock', OrderConstants::STOCK_AVAILABLE)->count(),
            'instrumentsAvailable' => InstrumentItems::where('in_stock', OrderConstants::STOCK_AVAILABLE)->count(),
            'instrumentsNotAddedToTray' => count($remainingInstrumentsId),
            'ordersRequested' => Orders::whereIn('status', OrderConstants::ORDERS_REQUESTED)->count(),
            'ordersInOT' => Orders::whereIn('status', OrderConstants::ORDERS_IN_OT_PROCESS)->count(),
            'ordersInSterilizations' => Orders::whereIn('status', OrderConstants::ORDERS_IN_STERILIZATION_PROCESS)->count(),
            'ordersReceivedBackToAdmin' => Orders::where('status', OrderConstants::STATUS_RETURNED_FROM_STERILIZATION_USER)->count(),
        ];
    }

    public function getCurrentMonthOrders()
    {
        $orders = DB::table(Orders::getTableName().' as o')
                    ->join(Operations::getTableName().' as op', 'op.id', '=','o.operation_id')
                    ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at','op.operation_name')
                    ->whereMonth('o.booking_date', '=', Carbon::now()->startOfMonth())
                    ->get();
        return $orders;
    }

    public function getOrdersByMonthAndYear($month, $year)
    {
        $orders = DB::table(Orders::getTableName().' as o')
                    ->join(Operations::getTableName().' as op', 'op.id', '=','o.operation_id')
                    ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at','op.operation_name')
                    ->whereMonth('o.booking_date', '=', $month)
                    ->whereYear('o.booking_date', '=', $year)
                    ->get();
        return $orders;
    }

    public function getPendingOtRequests()
    {
        return DB::table(Orders::getTableName().' as o')
            ->join(Operations::getTableName().' as op', 'op.id', '=','o.operation_id')
            ->join(User::getTableName().' as u', 'u.id', '=','o.user_id')
            ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at',
                'op.operation_name', 'u.ot_name')
            ->where('o.status', OrderConstants::STATUS_ORDER_PLACED)
            ->orderByDesc('o.created_at')
            ->limit(10)
            ->get();
    }
}

