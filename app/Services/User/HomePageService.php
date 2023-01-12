<?php

namespace App\Services\User;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\OrderConstants;

use App\Models\InstrumentItems;
use App\Models\Operations;
use App\Models\Orders;
use App\Models\TrayInstruments;
use App\Models\Trays;
use App\Models\User;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomePageService
{
    public function getStatisticsOfOrders()
    {
        return [
            'ordersRequested' => Orders::whereIn('status', OrderConstants::ORDERS_REQUESTED)->where('user_id', Auth::guard(AuthConstants::GUARD_USER)->id())->count(),
            'ordersInOT' => Orders::whereIn('status', OrderConstants::ORDERS_IN_OT_PROCESS)->where('user_id', Auth::guard(AuthConstants::GUARD_USER)->id())->count(),
            'ordersReturnedBacked' => Orders::whereIn('status', OrderConstants::ORDERS_RETURNED_BACK_FROM_OT)->where('user_id', Auth::guard(AuthConstants::GUARD_USER)->id())->count(),
            'totalOrders' => Orders::where('user_id', Auth::guard(AuthConstants::GUARD_USER)->id())->count(),
        ];
    }

    public function getCurrentMonthOrders()
    {
        $orders = DB::table(Orders::getTableName().' as o')
            ->join(Operations::getTableName().' as op', 'op.id', '=','o.operation_id')
            ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at','op.operation_name')
            ->whereMonth('o.booking_date', '=', Carbon::now()->startOfMonth())
            ->where('o.user_id', Auth::guard(AuthConstants::GUARD_USER)->id())
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
            ->where('o.user_id', Auth::guard(AuthConstants::GUARD_USER)->id())
            ->get();
        return $orders;
    }

    public function getActiveOrders()
    {
        return DB::table(Orders::getTableName().' as o')
            ->join(Operations::getTableName().' as op', 'op.id', '=','o.operation_id')
            ->join(User::getTableName().' as u', 'u.id', '=','o.user_id')
            ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at',
                'op.operation_name', 'u.ot_name')
            ->where('o.status', OrderConstants::STATUS_ISSUED_TO_OT_USER)
            ->where('o.user_id', Auth::guard(AuthConstants::GUARD_USER)->id())
            ->orderByDesc('o.created_at')
            ->limit(10)
            ->get();
    }

}
