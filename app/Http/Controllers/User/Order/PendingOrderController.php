<?php


namespace App\Http\Controllers\User\Order;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\OrderConstants;
use App\Http\Controllers\User\BaseController;

use App\Http\Requests\Admin\Inventory\Operation\OperationUpdateRequest;
use App\Http\Requests\User\Order\OrderStoreRequest;
use App\Http\Requests\User\Order\OrderUpdateRequest;
use App\Models\Categories;
use App\Models\InstrumentItems;
use App\Models\Operations;
use App\Models\OperationTrays;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\TrayCategory;
use App\Models\TrayInstruments;
use App\Models\Trays;
use App\Models\User;
use App\Services\InstrumentService;

use App\Services\OrderManagementService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Toastr;


class PendingOrderController extends BaseController
{

    /**
     *  Order Controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('order.pending-order');
        $this->addBaseRoute('order.pending-order');
    }

    /**
     * Pending Orders
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $orders = DB::table(Orders::getTableName().' as o')
            ->join(Operations::getTableName().' as op', 'op.id', '=','o.operation_id')
            ->join(User::getTableName().' as u', 'u.id', '=','o.user_id')
            ->select('o.id', 'o.user_id', 'o.doctor_name', 'o.barcode', 'o.booking_date', 'o.description', 'o.status', 'o.created_at',
                'op.operation_name', 'u.ot_name')
            ->where('o.status', OrderConstants::STATUS_ORDER_PLACED)
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
        return $this->renderView($this->getView('index'), compact('orders', 'operations'), 'Pending Orders');
    }

    /**
     * Show form to create order
     *
     * @param InstrumentService $instrumentService
     * @return Factory|View
     */
    public function create(InstrumentService $instrumentService)
    {
        $operations = Operations::pluck('operation_name', 'id');
        $trayCategory = TrayCategory::pluck('category_name', 'id');
        $instruments = $instrumentService->getInstrumentCategoryNotAssignedToTray();
        return $this->renderView($this->getView('create'), compact('operations', 'instruments', 'trayCategory'), 'Add Request');
    }


    /**
     * Store order to DB
     *
     * @param OrderStoreRequest $request
     * @param InstrumentService $instrumentService
     * @return RedirectResponse
     */
    public function store(OrderStoreRequest $request, InstrumentService $instrumentService)
    {
      
        DB::beginTransaction();
        try {
            // Create order
            $order = Orders::create([
                'user_id' => Auth::guard(AuthConstants::GUARD_OT_USER)->id(),
                'operation_id' => $request->operation_id,
                'doctor_name' => $request->doctor_name,
                'barcode' => $this->_generateUniqueBarcode(),
                'booking_date' => $request->booking_date,
                'description' => $request->description,
            ]);
            $orderTrayItems = [];
            $trayCategoryId = OperationTrays::where('operation_id', $request->operation_id)->pluck('tray_category_id')->toArray(); 
            foreach ($trayCategoryId as $key => $tray) {
                $orderTrayItems[] = [
                    'order_id' => $order->id,
                    'tray_category_id' => $tray,
                    'instrument_category_id' => null,
                    'qty' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            $additionalTray = $request->tray_category_id;
            if (!empty($additionalTray)) {
                foreach ($additionalTray as $key => $item) {
                    if(!empty( $item)) {
                        $orderTrayItems[] = [
                            'order_id' => $order->id,
                            'tray_category_id' => $item,
                            'instrument_category_id' => null,
                            'qty' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
            
            $additionalInstrumentCategories = $instrumentService->getCategoryDetailsCollection($request->instrument_category_id);
            foreach ($additionalInstrumentCategories as $category) {
                for ($i = 1; $i <= $request->get('category_id_' . $category->id); $i++) {
                    $orderTrayItems[] = [
                        'order_id' => $order->id,
                        'tray_category_id' => null,
                        'instrument_category_id' => $category->id,
                        'qty' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
            OrderItems::insert($orderTrayItems);
            DB::commit();
            Toastr::success('Order requested successfully');
        } catch (\Exception $e) {
            Toastr::error('Something Went Wrong! Please do contact admin');
            DB::rollback();
        }
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Show form to edit Operation
     *
     * @param Operations $operation
     * @param InstrumentService $instrumentService
     * @return Factory|View
     */
    public function edit(Orders $pending_order,InstrumentService $instrumentService)
    {
        $operations = Operations::pluck('operation_name', 'id');
        $trayCategory = TrayCategory::pluck('category_name', 'id');
        $additionalInstruments = $instrumentService->getAddittionalInstrumentInOrder($pending_order->id);
        $additionalInstrumentsLinked = OrderItems::where('order_id', $pending_order->id)->whereNull('tray_id')->pluck('instrument_category_id')->toArray();
        $instruments = $instrumentService->getInstrumentCategoryNotAssignedToTray();
        return $this->renderView($this->getView('edit'), compact('pending_order', 'operations', 'trayCategory', 'instruments', 'additionalInstruments',
         'additionalInstrumentsLinked'), 'Edit Orders');
    }

    /**
     * Update instrument
     *
     * @param OperationUpdateRequest $request
     * @param Operations $operation
     * @return RedirectResponse
     */
    public function update(OrderUpdateRequest $request, Orders $pending_order, InstrumentService $instrumentService)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $pending_order->update([
                'operation_id' => $request->operation_id,
                'doctor_name' => $request->doctor_name,
                'booking_date' => $request->booking_date,
                'description' => $request->description,
            ]);
            $orderTrayItems = [];
            $operationTraysLinkedData = $instrumentService->getTraysAddedForAnOperation($request->operation_id);
           
            foreach ($operationTraysLinkedData as $key => $tray) {
                foreach ($tray['items'] as $instrument) {

                    $orderTrayItems[] = [
                        'order_id' => $pending_order->id,
                        'tray_category_id' => $tray['tray_details']->tray_category_id,
                        'tray_id' => $tray['tray_details']->id,
                        'instrument_category_id' => $instrument->category_id,
                        'instrument_item_id' => $instrument->id,
                        'qty' => 1,
                        'returnable' => $instrument->returnable,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            $additionalTraysLinkedData = $instrumentService->getAddOnTraysDetailsFromCategory($request->tray_category_id);

            foreach ($additionalTraysLinkedData as $additionalTrayDetails) {
                if(!empty( $additionalTrayDetails)) {
                    foreach ($additionalTrayDetails['items'] as $instrument) {
                        $orderTrayItems[] = [
                            'order_id' => $pending_order->id,
                            'tray_category_id' => $additionalTrayDetails['tray_details']->tray_category_id,
                            'tray_id' => $additionalTrayDetails['tray_details']->id,
                            'instrument_category_id' => $instrument->category_id,
                            'instrument_item_id' => $instrument->id,
                            'qty' => 1,
                            'returnable' => $instrument->returnable,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
     
            $additionalInstrumentCategories = $instrumentService->getCategoryDetailsCollection($request->instrument_category_id);
            foreach ($additionalInstrumentCategories as $category) {
                for ($i = 1; $i <= $request->get('category_id_' . $category->id); $i++) {
                    $orderTrayItems[] = [
                        'order_id' => $pending_order->id,
                        'tray_category_id' => null,
                        'tray_id' => null,
                        'instrument_category_id' => $category->id,
                        'instrument_item_id' => null,
                        'qty' => 1,
                        'returnable' => $category->returnable,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
            // dd($orderTrayItems);
            if (! empty($orderTrayItems)) {
                OrderItems::where('order_id', $pending_order->id)->delete();
                OrderItems::insert($orderTrayItems);
            }

            DB::commit();
            Toastr::success('Order Request Updated Successfully');
        } catch (\Exception $e) {
            Toastr::error('Something Went Wrong! Please do contact admin');
            DB::rollback();
        }
        return redirect()->route($this->getRoute('index'));
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

    /**
     * Delete instrument
     *
     * @param Operations $operations
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Operations $operations)
    {
        $operations->delete();
        return Response::json(['success' => 'Instrument Deleted Successfully']);
    }

    public function getOperationTraysDetailsWithInstruments(Operations $operations, InstrumentService $instrumentService)
    {
        $traysLinkedData = $instrumentService->getTraysAddedForAnOperation($operations->id);
        $trayItemHtml = view($this->getView('includes.operation-tray-details'), compact('traysLinkedData'))->render();
        return Response::json(['status' => 1, 'tray_item' => $trayItemHtml]);
    }

    public function getSurgeryTraysDetailsWithInstruments(Operations $operations, InstrumentService $instrumentService)
    {
        $traysLinkedData = $instrumentService->getTrayCategoryAddedForAnOperation($operations->id);
        $trayItemHtml = view($this->getView('includes.operation-tray-details'), compact('traysLinkedData'))->render();
        return Response::json(['status' => 1, 'tray_item' => $trayItemHtml]);
    }

    public function geTraysDetailsWithInstruments(TrayCategory $trayCategory, InstrumentService $instrumentService)
    {
        $traysLinkedData = $instrumentService->getTrayDetailsOfNotAssignedToOperations($trayCategory->id);
        $trayItemHtml = '';
        if (! empty($traysLinkedData)) {
            $trayItemHtml = view($this->getView('includes.tray-details'), compact('traysLinkedData', 'trayCategory'))->render();
        } else {
            $trayItemHtml = '<p class="text-danger no-tray-items">No Trays available in under this category</p>';
        }
        return Response::json(['status' => 1, 'tray_item' => $trayItemHtml]);
    }

    public function geTraysDetailsWithInstrumentsInOperation(Request $request, TrayCategory $trayCategory, InstrumentService $instrumentService)
    {
        $traysLinkedData = $instrumentService->getTrayDetailsOfNotAssignedToOperation($trayCategory->id);
        $trayItemHtml = '';
        if (! empty($traysLinkedData)) {
            $trayItemHtml = view($this->getView('includes.tray-details'), compact('traysLinkedData', 'trayCategory'))->render();
        } else {
            $trayItemHtml = '<p class="text-danger no-tray-items">No Trays available in under this category</p>';
        }
        return Response::json(['status' => 1, 'tray_item' => $trayItemHtml]);
    }

    public function geInstrumentDetails(Categories $categories)
    {
        $trayItemHtml = view($this->getView('includes.instrument-details'), compact('categories'))->render();
        return Response::json(['status' => 1, 'instrument_item' => $trayItemHtml]);
    }

    /**
     * View Barcode for tray
     *
     * @param Trays $tray
     * @param Orders $orders
     * @return Factory|View
     */
    public function trayBarcode(Trays $tray, Orders $orders)
    {
        return $this->renderView($this->getView('tray-barcode'),  compact('tray', 'orders'), 'Tray Barcode Print');
    }

    /**
     * View Barcode for order
     *
     * @param Trays $tray
     * @param Orders $orders
     * @return Factory|View
     */
    public function orderBarcode(Orders $orders)
    {
        return $this->renderView($this->getView('order-barcode'),  compact('orders'), 'Order Barcode Print');
    }

    private function _generateUniqueBarcode()
    {
        do {
            $code = random_int(100000000000, 999999999999);
        } while (Orders::where('barcode', $code)->first());
        return $code;
    }

}
