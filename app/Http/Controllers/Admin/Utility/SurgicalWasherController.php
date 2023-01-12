<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Utility\SurgicalWasher\SurgicalWasherStoreRequest;
use App\Http\Requests\Admin\Utility\SurgicalWasher\SurgicalWasherUpdateRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\SurgicalWasher;
use Illuminate\Http\Request;
use Toastr;

class SurgicalWasherController extends BaseController
{
      /**
     * SurgicalWasher constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('utility.surgical-washer');
        $this->addBaseRoute('utility.surgical-washer');
    }


  /**
     * List categories
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $surgicalwasher = new SurgicalWasher();
        if ($request->has('washer_name')) {
            $surgicalwasher = $surgicalwasher->where('washer_name', 'LIKE', '%'.$request->washer_name.'%');
        }
        if ($request->has('company_name') && '' != $request->company_name) {
            $surgicalwasher = $surgicalwasher->where('company_name', $request->company_name);
        }
      
        $surgicalwasher = $surgicalwasher->orderbyDesc('created_at')->get();
        return $this->renderView($this->getView('index'), compact('surgicalwasher'), 'Surgical Washer');
    }



        /**
     * Show form to create surgical Washer
     *
     * @return Factory|View
     */
    public function create()
    {
        return $this->renderView($this->getView('create'), [], 'Add  Surgical Washer');
    }


    /**
     * Store surgical washer to DB
     *
     * @param InstrumentStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SurgicalWasherStoreRequest $request)
    {
         SurgicalWasher::create([
            'washer_name' => $request->washer_name,
            'company_name' => $request->company_name,
            'procedure' => $request->procedure,
            'remarks' => $request->remarks,
            'barcode' => $this->_generateUniqueBarcode(),
        ]);

        Toastr::success('Surgical Washer Created Successfully');
        return redirect()->route($this->getRoute('index'));
    }

     /**
     * Show form to edit instrument
     *
     * @param InstrumentItems $instrument
     * @return Factory|View
     */
    public function edit(SurgicalWasher $surgicalWasher)
    {
        return $this->renderView($this->getView('edit'), compact('surgicalWasher'), 'Edit Surgical Washer');
    }

    /**
     * Update surgical washer
     *
     * @param InstrumentUpdateRequest $request
     * @param InstrumentItems $instrument
     * @return RedirectResponse
     */
    public function update(SurgicalWasherUpdateRequest $request, SurgicalWasher $surgicalWasher)
    {
        $surgicalWasher->update([
            'washer_name' => $request->washer_name,
            'company_name' => $request->company_name,
            'procedure' => $request->procedure,
            'remarks' => $request->remarks,
        ]);

        Toastr::success('Surgical Washer Updated Successfully');
        return redirect()->route($this->getRoute('index'));
    }

    private function _generateUniqueBarcode()
    {
        do {
            $code = random_int(100000000000, 999999999999);
        } while (SurgicalWasher::where('barcode', $code)->first());
        return $code;
    }

    public function barcodeView(SurgicalWasher $surgicalWasher)
    {
        return $this->renderView($this->getView('barcode'),  compact('surgicalWasher'), 'Surgical Washer Reference');
    }

}
