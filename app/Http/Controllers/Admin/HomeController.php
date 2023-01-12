<?php

namespace App\Http\Controllers\Admin;

use App\Http\Constants\BloodGroupConstants;
use App\Http\Constants\UserConstants;
use App\Models\BloodBag;
use App\Models\BloodBagLog;
use App\Models\Refrigerator;
use App\Models\StorageRack;
use App\Services\Admin\HomePageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class HomeController extends BaseController
{

    /**
     * HomeController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->addBaseRoute('home');
        $this->addBaseView('home');
    }

    /**
     * Show the application dashboard.
     *
     * @param HomePageService $homePageService
     * @return Factory|View
     */
    public function index(HomePageService $homePageService)
    {
        return $this->renderView($this->getView('index'), [], 'Home');
    }



}
