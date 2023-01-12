<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show form to seller where they can save new password
     *
     * @param Request $request
     * @param null $token
     * @return Factory|View
     */
    public function showResetForm($token = null)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token]
        );
    }


    /**
     * returns Password broker of admina
     *
     * @return mixed
     */
    public function broker()
    {
        return Password::broker('admins');
    }


    /**
     * returns authentication guard of admin
     *
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

}
