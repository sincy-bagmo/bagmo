<?php

namespace App\Http\Controllers\User;

use App\Http\Constants\BloodGroupConstants;
use App\Models\BloodBag;
use App\Models\BloodBagLog;
use App\Models\Refrigerator;
use App\Models\StorageRack;
use App\Services\User\HomePageService;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


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
     * @return Renderable
     */
    public function index(HomePageService $homePageService)
    {
        $statisticsOfOrders = $homePageService->getStatisticsOfOrders();
        $activeOrders = $homePageService->getActiveOrders();
        $currentMonthOrders = $homePageService->getCurrentMonthOrders();
        return $this->renderView($this->getView('index'), compact(
            'statisticsOfOrders', 'activeOrders', 'currentMonthOrders'
        ), 'Home');
    }



}
