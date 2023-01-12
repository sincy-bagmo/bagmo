<?php

namespace App\Http\Controllers\User\Order;


use App\Http\Controllers\User\BaseController;

use Illuminate\Http\Request;


class AnalyticsController extends BaseController
{
    /**
     * AnalyticsController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->addBaseView('order.analytics');
        $this->addBaseRoute('order.analytics');
    }

    /**
     * Get Analytics
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return abort(404);
        return $this->renderView($this->getView('index'), [], 'Activities Analytics');
    }

}
