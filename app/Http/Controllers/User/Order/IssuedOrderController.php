<?php


namespace App\Http\Controllers\User\Order;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\InventoryConstants;
use App\Http\Constants\OrderConstants;
use App\Http\Controllers\User\BaseController;

use App\Http\Requests\Admin\Inventory\Operation\OperationUpdateRequest;
use App\Http\Requests\User\Order\OrderStoreRequest;
use App\Models\Categories;
use App\Models\InstrumentItems;
use App\Models\OrderItemMissing;
use App\Models\Operations;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Trays;
use App\Models\TrayWeight;
use App\Models\User;
use App\Services\InstrumentService;
use App\Services\User\IssuedOrderService;
use App\Services\OrderManagementService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Toastr;


class IssuedOrderController extends BaseController
{

    /**
     *  Order Controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('order.issued-order');
        $this->addBaseRoute('order.issued-order');
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
            ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at', 'order_send_to_ot_at',
                'op.operation_name', 'u.ot_name')
            ->where('o.status', OrderConstants::STATUS_ISSUED_TO_OT_USER)
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
        return $this->renderView($this->getView('index'), compact('orders', 'operations'), 'Issued Orders');
    }

    /** Show instrument details
     *
     * @param Request $request
     * @param Operations $operations
     * @return void
     */
    public function show(Orders $orders, IssuedOrderService $issuedOrderService)
    {
        $trayDetails = $issuedOrderService->getIssuedOrderTray($orders->id);
        $trayCount = !empty($trayDetails) ? count($trayDetails) : 0;
        $surgeryDetails = Operations::where('id', $orders->operation_id)->first();
        $instrumentDetails = $issuedOrderService->getIssuedOrderInstruments($orders->id);
        $instrumentCount = !empty($instrumentDetails) ? count($instrumentDetails) : 0;
        return $this->renderView($this->getView('view'), compact('orders', 'trayDetails', 'trayCount',
                'surgeryDetails', 'instrumentDetails', 'instrumentCount'), 'Issued Orders');
    }

    public function orderDetailsView(Orders $orders,  IssuedOrderService $issuedOrderService) 
    {
        $surgeryDetails = Operations::where('id', $orders->operation_id)->first();
        $trayDetails = $issuedOrderService->getIssuedOrderTray($orders->id);
        $instrumentDetails = $issuedOrderService->getIssuedOrderInstruments($orders->id);
        return $this->renderView($this->getView('order-details'),compact('orders', 'surgeryDetails', 'trayDetails', 'instrumentDetails'), 'Issued Orders');
    }

    public function orderDetails(Orders $orders, IssuedOrderService $issuedOrderService)
    {
        $surgeryDetails = Operations::where('id', $orders->operation_id)->first();
        $trayDetails = $issuedOrderService->getIssuedOrderTray($orders->id);
        $instrumentDetails = $issuedOrderService->getIssuedOrderInstruments($orders->id);
        $html = view($this->getView('includes.order-details'), compact('orders',
            'surgeryDetails', 'trayDetails', 'instrumentDetails'))->render();
        return Response::json(['status' => 1, 'html' => $html]);
    }

    public function orderReturn(Request $request, Orders $orders)
    {
        $missingData = [];
        // Tray Items
        $orderTrayItems = $request->order_item;
        foreach($orderTrayItems as $instrument => $item) {
            $trayDetails = Trays::find($item['tray_id']);
            if (isset($item['missing'])) {
                $instrumentDetails = InstrumentItems::where('id', $instrument)->first();
                $missingData[] = [
                    'order_id' => $orders->id,
                    'reported_by' => Auth::guard(AuthConstants::GUARD_OT_USER)->id(),
                    'reported_user_type' => OrderConstants::ORDER_MISSING_ADDED_BY_OT_USER,
                    'tray_category_id' => $trayDetails->tray_category_id,
                    'tray_id' => $trayDetails->id,
                    'instrument_category_id' => $instrumentDetails->category_id,
                    'instrument_item_id' => $instrumentDetails->id,
                    'missing' => InventoryConstants::INSTRUMENTS_MISSING_YES,
                    'damaged' => null,
                    'damaged_reason' => null,
                    'status' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            if (isset($item['damaged'])) {
                $instrumentDetails = InstrumentItems::where('id', $instrument)->first();
                $missingData[] = [
                    'order_id' => $orders->id,
                    'reported_by' => Auth::guard(AuthConstants::GUARD_OT_USER)->id(),
                    'reported_user_type' => OrderConstants::ORDER_MISSING_ADDED_BY_OT_USER,
                    'tray_category_id' => $trayDetails->tray_category_id,
                    'tray_id' => $trayDetails->id,
                    'instrument_category_id' => $instrumentDetails->category_id,
                    'instrument_item_id' => $instrumentDetails->id,
                    'missing' => null,
                    'damaged' => InventoryConstants::INSTRUMENTS_DAMAGED_YES,
                    'damaged_reason' => $item['damaged_reason'],
                    'status' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $tray = $request->get('tray-weight-' . $trayDetails->id);
            $trayWeight = TrayWeight::where('order_id', $orders->id)->where('tray_id', $trayDetails->id)->first();
            $trayWeight->update(['ot_weight'=> $tray]); 
        }

        // Instrument Items
        $orderInstrumentItems = $request->order_item_instrument;
        if (! is_null($orderInstrumentItems)) {
            foreach ($orderInstrumentItems as $instrument => $item) {
                if (isset($item['missing'])) {
                    $instrumentDetails = InstrumentItems::where('id', $instrument)->first();
                    $missingData[] = [
                        'order_id' => $orders->id,
                        'reported_by' => Auth::guard(AuthConstants::GUARD_OT_USER)->id(),
                        'reported_user_type' => OrderConstants::ORDER_MISSING_ADDED_BY_OT_USER,
                        'tray_category_id' => null,
                        'tray_id' => null,
                        'instrument_category_id' => $instrumentDetails->category_id,
                        'instrument_item_id' => $instrumentDetails->id,
                        'missing' => InventoryConstants::INSTRUMENTS_MISSING_YES,
                        'damaged' => InventoryConstants::INSTRUMENTS_DAMAGED_NO,
                        'damaged_reason' => null,
                        'status' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                if (isset($item['damaged'])) {
                    $instrumentDetails = InstrumentItems::where('id', $instrument)->first();
                    $missingData[] = [
                        'order_id' => $orders->id,
                        'reported_by' => Auth::guard(AuthConstants::GUARD_OT_USER)->id(),
                        'reported_user_type' => OrderConstants::ORDER_MISSING_ADDED_BY_OT_USER,
                        'tray_category_id' => null,
                        'tray_id' => null,
                        'instrument_category_id' => $instrumentDetails->category_id,
                        'instrument_item_id' => $instrumentDetails->id,
                        'missing' => InventoryConstants::INSTRUMENTS_MISSING_NO,
                        'damaged' => InventoryConstants::INSTRUMENTS_DAMAGED_YES,
                        'damaged_reason' => $item['damaged_reason'],
                        'status' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
        }
        if (!empty($missingData)) {
            OrderItemMissing::insert($missingData);
        }
        $orders->update([
            'order_returned_form_ot' => Carbon::now(),
            'status' => OrderConstants::STATUS_RETURNED_FROM_OT_USER,
        ]);
        Toastr::success('Order Returned To Collection User Successfully');
        return redirect()->route($this->getRoute('index'));
    }

    public function missingInstruments(Orders $orders, Request $request): JsonResponse
    {
        if (OrderItemMissing::where('order_id', $orders->id)->exists()) {
            OrderItemMissing::where('order_id', $orders->id)->update([
                'order_id' => $orders->id,
                'tray_id' => $request->trayId,
                'category_id' => $request->category,
                'instrument_item_id' =>$request->instrument,
                'missing' => InventoryConstants::INSTRUMENTS_MISSING_YES
            ]);
        } else {
            OrderItemMissing::create([
                'order_id' => $orders->id,
                'tray_id' => $request->trayId,
                'category_id' => $request->category,
                'instrument_item_id' => $request->instrument,
                'missing' => InventoryConstants::INSTRUMENTS_MISSING_YES]);
        }
        return Response::json(['status' => 1, 'success' => 'instrument missing added successfully']);
    }


    public function damagedInstruments(Orders $orders, Request $request): JsonResponse
    {
        if (OrderItemMissing::where('order_id', $orders->id)->exists()) {
            OrderItemMissing::where('order_id', $orders->id)->update([
                'order_id' => $orders->id,
                'tray_id' => $request->trayId,
                'category_id' => $request->category,
                'instrument_item_id' => $request->instrument,
                'damaged' => InventoryConstants::INSTRUMENTS_DAMAGED_YES,
                'damaged_reason' => $request->reason
            ]);
        } else {
            OrderItemMissing::create([
                'order_id' => $orders->id,
                'tray_id' => $request->trayId,
                'category_id' => $request->category,
                'instrument_item_id' => $request->instrument,
                'damaged' => InventoryConstants::INSTRUMENTS_DAMAGED_YES,
                'damaged_reason' => $request->reason
            ]);
        }
        return Response::json(['status' => 1, 'success' => 'instrument damaged added successfully']);
    }


}
