<?php

namespace App\Http\Controllers\Admin\Refrigerator;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Refrigerator\RefrigeratorStoreRequest;
use App\Http\Requests\Admin\Refrigerator\RefrigeratorUpdateRequest;
use App\Models\Refrigerator;
use App\Models\StorageRack;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Toastr;

class RefrigeratorController extends BaseController
{
    /**
     * RefrigeratorController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('refrigerator');
        $this->addBaseRoute('refrigerator');
    }

    /**
     * List Refrigerator
     *
     * @return Factory|View
     */
    public function index(Request  $request)
    {
        $refrigerator = new Refrigerator();
        if ($request->has('refrigerator_name')) {
            $refrigerator = $refrigerator->where('refrigerator_name', 'LIKE', '%'.$request->refrigerator_name.'%');
        }
        if ($request->has('company') && '' != $request->company) {
            $refrigerator = $refrigerator->where('company', $request->company);
        }
        if ($request->has('type') && '' != $request->type) {
            $refrigerator = $refrigerator->where('type', $request->type);
        }
        if ($request->has('reference_number') && '' != $request->reference_number) {
            $refrigerator = $refrigerator->where('reference_number', $request->reference_number);
        }
        if ($request->has('indication_name') && '' != $request->indication_name) {
            $refrigerator = $refrigerator->where('indication_name', $request->indication_name);
        }

        $refrigerator = $refrigerator->orderbyDesc('created_at')->get();
        return $this->renderView($this->getView('index'), compact('refrigerator'), 'Refrigerator');
    }

    /**
     * Show form to create department
     *
     * @return Factory|View
     */
    public function create()
    {
        return $this->renderView($this->getView('create'), [], 'Add  Refrigerator');
    }


    /**
     * Store department to DB
     *
     * @param RefrigeratorStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RefrigeratorStoreRequest $request)
    {
        DB::beginTransaction();
        try {
        $refregerator = Refrigerator::create([
            'refrigerator_name' => $request->refrigerator_name,
            'type' => $request->type,
            'reference_number' => $request->reference_number,
            'company' => $request->company,
            'indication_name' => $request->indication_name,
            'remarks' => $request->remarks,
            'barcode' => $this->_generateUniqueRefrigeratorBarcode(),
        ]);
        // Add Rack Details
        if (! empty($request->rack_name)) {
            foreach ($request->rack_name as $item) {
                StorageRack::create([
                    'refrigerator_id' => $refregerator->id,
                    'rack_name' => $item,
                    'rack_barcode' => $this->_generateUniqueRackBarcode(),
                ]);
            }
        }
        Toastr::success('Refrigerator Added Successfully');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('Failed to add refrigerator');
        }
        return redirect()->route($this->getRoute('index'));
    }


    /**
     * Show form to edit refrigerator
     *
     * @param Refrigerator $refrigerator
     * @return Factory|View
     */
    public function edit(Refrigerator $refrigerator)
    {
        return $this->renderView($this->getView('edit'), compact('refrigerator'), 'Edit Refrigerator');
    }

    /**
     * Update department
     *
     * @param RefrigeratorUpdateRequest $request
     * @param Refrigerator $refrigerator
     * @return RedirectResponse
     */
    public function update(RefrigeratorUpdateRequest $request, Refrigerator $refrigerator)
    {
        $refrigerator->update([
            'refrigerator_name' => $request->refrigerator_name,
            'type' => $request->type,
            'reference_number' => $request->reference_number,
            'company' => $request->company,
            'indication_name' => $request->indication_name,
            'remarks' => $request->remarks,
        ]);
        Toastr::success('Refrigerator updated successfully');
        return redirect()->route($this->getRoute('index'));
    }

    private function _generateUniqueRefrigeratorBarcode()
    {
        do {
            $code = random_int(1000000000, 9999999999);
        } while (Refrigerator::where('barcode', $code)->first());
        return $code;
    }

    private function _generateUniqueRackBarcode()
    {
        do {
            $code = random_int(1000000000, 9999999999);
        } while (StorageRack::where('rack_barcode', $code)->first());
        return $code;
    }

    /**
     * Display the specified resource.
     *
     * @param  Refrigerator  $refrigerator
     * @return Factory|View
     */
    public function show(Refrigerator  $refrigerator)
    {
        $rack = StorageRack::where('refrigerator_id', $refrigerator->id)->get();
        return $this->renderView($this->getView('view'), compact('refrigerator','rack'), 'Racks');
    }

    /**
     * View Barcode for refrigerator
     *
     * @param Refrigerator $refrigerator
     * @return Factory|View
     */
    public function refrigeratorBarcode(Refrigerator $refrigerator)
    {
        return $this->renderView($this->getView('refrigerator-barcode'),  compact('refrigerator'), 'Refrigerator Barcode Print');
    }

    /**
     * View Barcode for refrigerator
     *
     * @param Refrigerator $refrigerator
     * @return Factory|View
     */
    public function rackBarcode(Refrigerator $refrigerator)
    {
        $rack = StorageRack::where('refrigerator_id', $refrigerator->id)->get();
        return $this->renderView($this->getView('rack-barcode'),  compact('refrigerator', 'rack'), 'Refrigerator Barcode Print');
    }
}
