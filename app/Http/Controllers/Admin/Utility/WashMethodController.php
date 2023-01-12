<?php


namespace App\Http\Controllers\Admin\Utility;

use App\Http\Controllers\Admin\BaseController;

use App\Http\Requests\Admin\Utility\WashMethodStoreRequest;
use App\Http\Requests\Admin\Utility\WashMethodUpdateRequest;

use App\Models\LookupWashMethods;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Toastr;


class WashMethodController extends BaseController
{


    /**
     * Wash methods controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('utility.wash-method');
        $this->addBaseRoute('utility.wash-method');
    }

    /**
     * List wash methods
     *
     * @return Factory|View
     */
    public function index()
    {
        $method = LookupWashMethods::get();
        return $this->renderView($this->getView('index'), compact('method'), ' Wash Methods');
    }

    /**
     * Show form to create wash-method
     *
     * @return Factory|View
     */
    public function create()
    {
        return $this->renderView($this->getView('create'), [], 'Add Wash Method');
    }


    /**
     * Store wash-method to DB
     *
     * @param WashMethodStoreRequest $request
     * @return RedirectResponse
     */
    public function store(WashMethodStoreRequest $request)
    {
        LookupWashMethods::create([
            'method_name' => $request->method_name,
            'description' => $request->description,
        ]);
        Toastr::success('Wash Method Added Successfully');
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Show form to edit wash-method
     *
     * @param LookupWashMethods $wash_method
     * @return Factory|View
     */
    public function edit(LookupWashMethods $wash_method)
    {
        return $this->renderView($this->getView('edit'), compact('wash_method'), 'Edit Wash Methods');
    }

    /**
     * Update wash method
     *
     * @param WashMethodUpdateRequest $request
     * @param LookupWashMethods $wash_method
     * @return RedirectResponse
     */
    public function update(WashMethodUpdateRequest $request, LookupWashMethods $wash_method)
    {
        $wash_method->update([
            'method_name' => $request->method_name,
            'description' => $request->description,
        ]);
        Toastr::success('Wash methods updated successfully');
        return redirect()->route($this->getRoute('index'));
    }

}
