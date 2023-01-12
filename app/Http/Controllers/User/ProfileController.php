<?php

namespace App\Http\Controllers\User;

use App\Http\Constants\AuthConstants;
use App\Http\Constants\FileDestinations;

use App\Http\Helpers\Core\FileManager;

use App\Http\Requests\User\Profile\PasswordUpdateRequest;
use App\Http\Requests\User\Profile\ProfileUpdateRequest;

use App\Models\UserLoginLog;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Validator;
use Toastr;


class ProfileController extends BaseController
{

    /**
     * ProfileController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->addBaseView('profile');
        $this->addBaseRoute('profile');
    }

    /**
     * Show profile edit page
     *
     * @return Factory|View
     */
    public function index()
    {
        return $this->renderView($this->getView('profile'), [], 'Profile');
    }

    /**
     * Update profile
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::guard(AuthConstants::GUARD_USER)->user();
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
        ];
        if ($request->hasFile('profile_image')) {
            $response = FileManager::upload(FileDestinations::PROFILE_OT_USER,'profile_image' );
            if ($response['status']) {
                $data['profile_image'] = $response['data']['fileName'];
            }
        }
        $user->update($data);
        Toastr::success('profile updated successfully');
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Show form to change password
     *
     * @return Factory|View
     */
    public function viewChangePassword()
    {
        return $this->renderView($this->getView('change-password'),[], 'Change Password');
    }

    /**
     * Update password
     *
     * @param PasswordUpdateRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = Auth::guard(AuthConstants::GUARD_USER)->user();
        if (Hash::check($request['current_password'],$user->password)) {
            $user->update([
                'password' => bcrypt($request->password)
            ]);
            Toastr::success('Password updated  successfully');
        } else {
            Toastr::error('You entered wrong password!!');
        }
        return redirect()->back();
    }


    /**
     * Recent Logins
     *
     * @return Factory|View
     */
    Public function viewRecentLogin()
    {
        $userLoginLogs =  UserLoginLog::orderBy('id', 'desc')->get();
        return $this->renderView($this->getView('recent-login'), compact('userLoginLogs'), 'Recent Login');
    }

}
