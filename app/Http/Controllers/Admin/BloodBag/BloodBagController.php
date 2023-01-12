<?php

namespace App\Http\Controllers\Admin\BloodBag;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\BloodGroupConstants;
use App\Http\Constants\IsbtConstants;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Core\DateHelper;
use App\Models\BloodBag;
use App\Http\Requests\Admin\BloodBag\BloodBagStoreRequest;
use App\Http\Requests\Admin\BloodBag\BloodBagUpdateRequest;
use App\Models\BloodBagLog;
use App\Models\Refrigerator;
use App\Models\StorageRack;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Toastr;

class BloodBagController extends BaseController
{
    /**
     * BloodBagController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('blood-bag');
        $this->addBaseRoute('blood-bag');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $bloodBag =  DB::table(BloodBag::getTableName() . ' as bg')
            ->join(Refrigerator::getTableName() . ' as r', 'r.id','=','bg.refrigerator_id')
            ->join(StorageRack::getTableName() . ' as sr', 'sr.id','=','bg.storage_rack_id')
            ->select('bg.id', 'bg.blood_bag_name', 'bg.type', 'bg.blood_group', 'bg.product_id', 'bg.volume', 'bg.expiry_date', 'bg.status', 'r.refrigerator_name', 'sr.rack_name')->get();
        return $this->renderView($this->getView('index'), compact('bloodBag'), 'Blood Bag');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $refrigerator = Refrigerator::pluck('refrigerator_name', 'id');
        return $this->renderView($this->getView('create'), compact('refrigerator'), 'Add  Blood Bag');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BloodBagStoreRequest $request
     * @return RedirectResponse
     */
    public function store(BloodBagStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $bloodGroup  = substr($request->blood_group, 2);
            $bloodGroup = str_split($bloodGroup, 2);
            $bloodBag = BloodBag::create([
                'refrigerator_id' => $request->refrigerator_id,
                'storage_rack_id' => $request->storage_rack_id,
                'blood_bag_name' => substr($request->blood_bag_name, 1),
                'type' => $request->type,
                'blood_group' =>  IsbtConstants::ABO_AND_RHD_BLOOD_GROUP[($bloodGroup[0])],
                'product_id' => $request->product_id,
                'volume' => $request->volume,
                'expiry_date' => DateHelper::format($request->expiry_date, 'Y-m-d'),
                'status' => BloodGroupConstants::BLOOD_BAG_STATUS_IN,
            ]);
            BloodBagLog::create([
                'refrigerator_id' => $request->refrigerator_id,
                'storage_rack_id' => $request->storage_rack_id,
                'blood_bag_id' => $bloodBag->id,
                'scan_in' => Carbon::now(),
                'status' => BloodGroupConstants::BLOOD_BAG_STATUS_IN,
            ]);
            Toastr::success('Blood Bag Added Successfully');
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Toastr::error('Failed to add blood bag');
        }
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  BloodBag  $bloodBag
     * @return Factory|View
     */
    public function show(BloodBag  $bloodBag)
    {
        $bloodBagDetails =  DB::table(Refrigerator::getTableName() . ' as r')
            ->join(StorageRack::getTableName() . ' as sr', 'sr.id','=','r.id')
            ->select('r.refrigerator_name', 'sr.rack_name')
            ->where('r.id', $bloodBag->refrigerator_id)
            ->first();
        $bloodBagLog = BloodBagLog::where('blood_bag_id', $bloodBag->id)->first();
        return $this->renderView($this->getView('view'), compact('bloodBagLog','bloodBag','bloodBagDetails'), 'Blood Bag');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Ajax to load hospital number
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function getRefriferatorRack(Refrigerator $refrigerator)
    {
        $rack = StorageRack::where('refrigerator_id', $refrigerator->id)->pluck('rack_name', 'id');
        $rackInput = view($this->getView('includes.rack-suggestions'), compact('rack'))->render();
        return Response::json(['status' => 1, 'rack' => $rackInput]);
    }

    public function scanRefrigeratorBarcode(Request $request)
    {
        $status = 0;
        if (Refrigerator::where('barcode', $request->refrigerator_id)->exists()) {
            $refrigerator = Refrigerator::where('barcode', $request->refrigerator_id)->first();
            $rack = StorageRack::where('refrigerator_id', $refrigerator->id)->pluck('rack_name', 'id');
            $rackInput = view($this->getView('includes.rack-suggestions'), compact('rack'))->render();
            $status = 1;
        }
        return Response::json(['status' => $status, 'rack' => $rackInput]);
    }

    public function checkBagName(Request $request)
    {
        $status = 0;
        $bagId = [];
        if (!empty($request->bag_no) && strlen($request->bag_no) == 16) {
            $bagId = substr($request->bag_no, 1);
            $status = 1;
        }
        return Response::json(['status' => $status,'data' => $bagId]);
    }

    public function checkProductId(Request $request)
    {
        $status = 0;
        $product = [];
        if (!empty($request->product) && strlen($request->product) == 10) {
            $product = substr($request->product, 2);
            $status = 1;
        }
        return Response::json(['status' => $status,'data' => $product]);
    }

    public function checkBloodGroup(Request $request)
    {
        $status = 0;
        $bloodGroup = [];
        if (!empty($request->blood_group) && strlen($request->blood_group) == 6) {
            $bloodGroup  = substr($request->blood_group, 2);
            $status = 1;
        }
        return Response::json(['status' => $status,'data' => $bloodGroup]);
    }

    public function checkExpiryDate(Request $request)
    {
        $status = 0;
        $expiry = [];
        if (!empty($request->expiry) && strlen($request->expiry) == 8) {
            $expiry = substr($request->expiry, 2);
            $readings = str_split($expiry, 3);
            $currentYear = substr(Carbon::today()->format('Y'),1);
            if (! empty($readings)) {
                if ($readings[0] >= $currentYear) {
                    $status = 1;
                }
            }
        }
        return Response::json(['status' => $status,'data' => $expiry]);
    }

    public function scanBarcodeToBloodBagOut()
    {
        return $this->renderView($this->getView('scan-barcode-out'), [], 'Scan Barcode');
    }

    public function scanBarcodeToBloodBagIn()
    {
        return $this->renderView($this->getView('scan-barcode-in'), [], 'Scan Barcode');
    }

    public function getDetailsOnBarcodeScan(Request $request)
    {
        $status = 0;
        $bloodBag = [];

        if (!empty($request->blood_bag_id)) {
            $bloodBag = DB::table(BloodBag::getTableName() . ' as bb')
                ->join(Refrigerator::getTableName() . ' as r', 'r.id','=','bb.refrigerator_id')
                ->join(StorageRack::getTableName() . ' as sr', 'sr.id','=','bb.storage_rack_id')
                ->join(BloodBagLog::getTableName() . ' as bl', 'bl.blood_bag_id','=','bb.id')
                ->select('r.refrigerator_name', 'sr.rack_name', 'bb.blood_bag_name', 'bl.scan_in', 'bl.scan_out', 'bb.status', 'bl.id')
                ->where('bb.blood_bag_name', substr($request->bag_no, 1))
                ->orderByDesc('bl.id')
                ->first();
            $bloodBag->status = BloodGroupConstants::BLOOD_BAG_STATUS[$bloodBag->status];
            $status = 1;
        }
        return Response::json(['status' => $status,'data' =>  $bloodBag]);
    }

    public function BagScanOut(Request $request)
    {
        DB::beginTransaction();
        try {
           if (BloodBag::where('blood_bag_name', substr($request->blood_bag_id, 1))->exists() ) {
               $bloodBag =  BloodBag::where('blood_bag_name', substr($request->blood_bag_id, 1))->first();
               $bloodBagLog = BloodBagLog::where('blood_bag_id', $bloodBag->id)->orderByDesc('id')->first();
               if ( $bloodBagLog->status == BloodGroupConstants::BLOOD_BAG_STATUS_IN ) {
                   BloodBagLog::where('blood_bag_id', $bloodBag->id)->update(['status' => BloodGroupConstants::BLOOD_BAG_STATUS_OUT, 'scan_out' => Carbon::now()]);
                   $bloodBag->update(['status' => BloodGroupConstants::BLOOD_BAG_STATUS_OUT]);
               }
               Toastr::success('Blood Bag Out Successfully');
           } else {
               return redirect()->route($this->getRoute('create'));
           }
           DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Toastr::error('Failed to out blood bag');
        }
        return redirect()->route($this->getRoute('index'));
    }

    public function BagScanIn(Request $request)
    {
        DB::beginTransaction();
        try {
            $refrigerator = Refrigerator::where('barcode', $request->refrigerator_id)->first();
            if (BloodBag::where('blood_bag_name', substr($request->bag_no, 1))->exists() ) {
                $bloodBag =  BloodBag::where('blood_bag_name', substr($request->bag_no, 1))->first();
                $bloodBagLog = BloodBagLog::where('blood_bag_id', $bloodBag->id)->orderByDesc('id')->first();
                if ( $bloodBagLog->status == BloodGroupConstants::BLOOD_BAG_STATUS_OUT ) {
                    BloodBagLog::create([
                        'refrigerator_id' => $refrigerator->id,
                        'storage_rack_id' => $request->storage_rack_id,
                        'blood_bag_id' => $bloodBag->id,
                        'scan_in' => Carbon::now(),
                        'status' => BloodGroupConstants::BLOOD_BAG_STATUS_IN,
                    ]);
                    $bloodBag->update(['status' => BloodGroupConstants::BLOOD_BAG_STATUS_IN]);
                }
                Toastr::success('Blood Bag In Successfully');
            } else {
                return redirect()->route($this->getRoute('create'));
            }
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Toastr::error('Failed to in blood bag');
        }
        return redirect()->route($this->getRoute('index'));
    }

    public function history(BloodBag  $bloodBag)
    {
        $bloodBagDetails =  DB::table(Refrigerator::getTableName() . ' as r')
            ->join(StorageRack::getTableName() . ' as sr', 'sr.id','=','r.id')
            ->select('r.refrigerator_name', 'sr.rack_name')
            ->where('r.id', $bloodBag->refrigerator_id)
            ->first();
        $bloodBagLog = BloodBagLog::where('blood_bag_id', $bloodBag->id)->get();
        return $this->renderView($this->getView('history'), compact('bloodBagLog','bloodBag','bloodBagDetails'), 'Blood Bag');
    }

    public function getBagDetails(Request  $request)
    {
        $bagId = substr($request->blood_bag_id, 1);
        if (BloodBag::where('blood_bag_name', $bagId)->exists()) {
            $bloodBag = BloodBag::where('blood_bag_name', $bagId)->orderByDesc('id')->first();
            $status = 0;
            if ($bloodBag->status == BloodGroupConstants::BLOOD_BAG_STATUS_IN) {
                return redirect()->route($this->getRoute('scan-barcode-out'));
            } else {
                return redirect()->route($this->getRoute('scan-barcode-in'));
            }
        } else {
            return redirect()->route($this->getRoute('create'));
        }
    }

}
