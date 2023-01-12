<?php


namespace App\Http\Controllers\Admin\Utility;

use App\Http\Controllers\Admin\BaseController;

use App\Http\Requests\Admin\Utility\DepartmentStoreRequest;
use App\Http\Requests\Admin\Utility\DepartmentUpdateRequest;

use App\Models\LookupDepartments;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Toastr;


class DepartmentController extends BaseController
{

    /**
     * DepartmentController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addBaseView('utility.department');
        $this->addBaseRoute('utility.department');
    }

    /**
     * List department
     *
     * @return Factory|View
     */
    public function index()
    {
        $department = LookupDepartments::get();
        return $this->renderView($this->getView('index'), compact('department'), 'Departments');
    }

    /**
     * Show form to create department
     *
     * @return Factory|View
     */
    public function create()
    {
        return $this->renderView($this->getView('create'), [], 'Add  Department');
    }


    /**
     * Store department to DB
     *
     * @param DepartmentStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DepartmentStoreRequest $request)
    {
        LookupDepartments::create([
           'department_name' => $request->department_name,
           'description' => $request->description,
           'barcode' => $this->_generateUniqueBarcode(),
        ]);
        Toastr::success('Department Added Successfully');
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Show form to edit department
     *
     * @param LookupDepartments $department
     * @return Factory|View
     */
    public function edit(LookupDepartments $department)
    {
        return $this->renderView($this->getView('edit'), compact('department'), 'Edit Department');
    }

    /**
     * Update department
     *
     * @param DepartmentUpdateRequest $request
     * @param LookupDepartments $department
     * @return RedirectResponse
     */
    public function update(DepartmentUpdateRequest $request, LookupDepartments $department)
    {
        $department->update([
            'department_name' => $request->department_name,
            'description' => $request->description,
        ]);
        Toastr::success('Department updated successfully');
        return redirect()->route($this->getRoute('index'));
    }

    private function _generateUniqueBarcode()
    {
        do {
            $code = random_int(100000000000, 999999999999);
        } while (LookupDepartments::where('barcode', $code)->first());
        return $code;
    }
}
