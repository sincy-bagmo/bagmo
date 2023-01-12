<?php


namespace App\Http\Controllers\User\Order;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\OrderConstants;
use App\Http\Controllers\User\BaseController;

use App\Models\Operations;
use App\Models\Orders;
use App\Models\User;


use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Toastr;


class ReturnedOrderController extends BaseController
{

    /**
     *  Order Controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('order.returned-order');
        $this->addBaseRoute('order.returned-order');
    }

    /**
     * Pending Orders
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $orders = DB::table(Orders::getTableName().' as o')
            ->join(Operations::getTableName().' as op', 'op.id', '=','o.operation_id')
            ->join(User::getTableName().' as u', 'u.id', '=','o.user_id')
            ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at', 'o.order_returned_form_ot',
                'op.operation_name', 'u.ot_name')
            ->whereNotIn('o.status', [OrderConstants::STATUS_ORDER_PLACED, OrderConstants::STATUS_ISSUED_TO_OT_USER])
            ->where('o.user_id', Auth::guard(AuthConstants::GUARD_OT_USER)->id());

        if ($request->has('barcode') && '' != $request->barcode) {
            $orders = $orders->where('o.barcode', $request->barcode);
        }
        if ($request->has('operation') && '' != $request->operation) {
            $orders = $orders->where('o.operation_id', $request->operation);
        }
        if ($request->has('surgery_date') && '' != $request->surgery_date) {
            $orders = $orders->whereDate('o.booking_date', $request->surgery_date);
        }
        if ($request->has('requested_date') && '' != $request->requested_date) {
            $orders = $orders->whereDate('o.created_at', $request->requested_date);
        }

        $operations = Operations::pluck('operation_name', 'id');
        $orders = $orders->orderByDesc('o.created_at')->get();
        return $this->renderView($this->getView('index'), compact('orders', 'operations'), 'Returned Orders');
    }

    /** Show instrument details
     *
     * @param Request $request
     * @param Operations $operations
     * @return void
     */
    public function show(Request $request, Operations $operations)
    {

    }

}
