<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/user';

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm($token = null)
    {
        return view('pages.user.auth.passwords.reset')->with(
            ['token' => $token]
        );
    }


    /**
     * returns Password broker of OT Users
     *
     * @return mixed
     */
    public function broker()
    {
        return Password::broker('users');
    }


    /**
     * returns authentication guard of OT Users
     *
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard(AuthConstants::GUARD_OT_USER);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);
        $user->setRememberToken(Str::random(60));
        $user->status = UserConstants::STATUS_ACTIVE;
        $user->save();
        event(new PasswordReset($user));
        $this->guard()->login($user);
    }
}
