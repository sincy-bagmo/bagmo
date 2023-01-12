<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Http\Controllers\Admin\BaseController;

use App\Http\Requests\Admin\Utility\SterilizationMethodStoreRequest;
use App\Http\Requests\Admin\Utility\SterilizationMethodUpdateRequest;
use App\Http\Requests\Admin\Utility\WashMethodStoreRequest;
use App\Http\Requests\Admin\Utility\WashMethodUpdateRequest;

use App\Models\SterilizationMethods;
use App\Models\LookupWashMethods;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Toastr;

class SterilizationMethodController extends BaseController
{


    /**
     * Sterilization methods controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('utility.sterilization-method');
        $this->addBaseRoute('utility.sterilization-method');
    }

    /**
     * List Sterilization methods
     *
     * @return Factory|View
     */
    public function index()
    {
        $method = SterilizationMethods::get();
        return $this->renderView($this->getView('index'), compact('method'), ' Sterilization Methods');
    }

    /**
     * Show form to create Sterilization-method
     *
     * @return Factory|View
     */
    public function create()
    {
        return $this->renderView($this->getView('create'), [], 'Add Sterilization Method');
    }


    /**
     * Store Sterilization-method to DB
     *
     * @param SterilizationMethodStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SterilizationMethodStoreRequest $request)
    {
        SterilizationMethods::create([
            'sterilization_method_name' => $request->sterilization_method_name,
            'description' => $request->description,
        ]);
        Toastr::success('Sterilization Method Added Successfully');
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Show form to edit Sterilization-method
     *
     * @param SterilizationMethods $sterilization_method
     * @return Factory|View
     */
    public function edit(SterilizationMethods $sterilization_method)
    {
        return $this->renderView($this->getView('edit'), compact('sterilization_method'), 'Edit Sterilization Methods');
    }

    /**
     * Update Sterilization method
     *
     * @param SterilizationMethodUpdateRequest $request
     * @param SterilizationMethods $sterilization_method
     * @return RedirectResponse
     */
    public function update(SterilizationMethodUpdateRequest $request, SterilizationMethods $sterilization_method)
    {
        $sterilization_method->update([
            'sterilization_method_name' => $request->sterilization_method_name,
            'description' => $request->description,
        ]);
        Toastr::success('Sterilization methods updated successfully');
        return redirect()->route($this->getRoute('index'));
    }
}
