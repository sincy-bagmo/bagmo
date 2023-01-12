<?php
/**
 * Created by Agin.
 * User: Agin
 * Date: 26/10/18
 * Time: 2:14 PM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class BaseController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:admin');
        $this->_view = 'pages.admin.';
        $this->addBaseRoute('admin.');
    }

}
