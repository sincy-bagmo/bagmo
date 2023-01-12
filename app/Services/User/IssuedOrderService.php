<?php


namespace App\Services\User;

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
use App\Http\Constants\AuthConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Constants\NotificationConstants;
use App\Models\TrayWeight;
use Illuminate\Support\Facades\DB;


class IssuedOrderService
{
	public function getIssuedOrderTray($orderId)
	{
		$traysLinkedData = [];
		$linkedData = DB::table(OrderItems::getTableName().' as oi')
			->join(Orders::getTableName().' as o', 'o.id', '=', 'oi.order_id')
			->join(Trays::getTableName().' as t','t.id', 'oi.tray_id')
			->select('t.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at', 'o.order_send_to_ot_at',
				  't.tray_name', 't.barcode', 't.weight',  't.in_stock', 't.last_wash_cycle', 't.image', 'oi.qty', 'oi.returnable')
            ->where('oi.order_id', $orderId)
			->where('o.user_id', Auth::guard(AuthConstants::GUARD_OT_USER)->id())
			->where('o.status', OrderConstants::STATUS_ISSUED_TO_OT_USER)->get();

			foreach ($linkedData as $item) {
				$traysLinkedData[$item->id]['tray_details'] = $item;
				$traysLinkedData[$item->id]['items'] = DB::table(TrayInstruments::getTableName().' as ti')
					->join(InstrumentItems::getTableName().' as i','i.id', 'ti.instrument_item_id')
					->join(Categories::getTableName().' as c', 'c.id', 'i.category_id')
					->select('i.id', 'c.category_name', 'c.weight', 'i.barcode', 'c.image', 'i.expiry', 'i.category_id', 'c.returnable', 'ti.tray_id')
					->where('ti.tray_id', $item->id)
					->whereNull('i.deleted_at')
					->orderbyDesc('ti.created_at')->get();
					$traysLinkedData[$item->id]['tray_details']->stockWeight = TrayWeight::where('tray_id', $item->id)->where('order_id', $orderId)->value('stock_weight');
			}
			return $traysLinkedData;
	}

	public function getIssuedOrderInstruments($orderId)
    {
        return DB::table(OrderItems::getTableName().' as oi')
			->join(Orders::getTableName().' as o', 'o.id', '=', 'oi.order_id')
            ->join(Categories::getTableName().' as c', 'c.id', 'oi.instrument_category_id')
            ->join(InstrumentItems::getTableName().' as i', 'i.id', 'oi.instrument_item_id')
            ->select('oi.instrument_category_id', 'oi.instrument_item_id', 'oi.id AS order_item_id',
                'c.category_name', 'c.type', 'c.image', 'c.returnable',
                'c.code', 'i.barcode', 'i.expiry', 'c.weight'
            )
            ->where('oi.order_id', $orderId)
            ->whereNull('oi.tray_id')
			->whereNull('oi.tray_category_id')
			->where('o.status', OrderConstants::STATUS_ISSUED_TO_OT_USER)
            ->orderbyDesc('oi.created_at')
            ->get();
    }
}
