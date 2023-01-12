<?php
/*
 * User management service
 *
 * @author Agin
 * @date 21-March-2022
 */

namespace App\Services\Admin;

use App\Http\Constants\UserConstants;
use App\Mail\JoinCssdFamily;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Exception;
use Toastr;

class UserManagementService
{

    /**
     * Send Welcome emails to users with password reset
     *
     * @param $userDetails
     * @param $createdBy
     * @param $type
     */
    public function sendWelcomeEmailWithResetPassword($userDetails, $createdBy, $type)
    {
        try {
            switch ($type) {

                case UserConstants::USER_TYPE_OT:
                    $token =  Password::broker('users')->createToken($userDetails);
                    DB::table('user_password_resets')->updateOrInsert([
                        'email' => $userDetails->email],[
                        'token' => bcrypt($token),
                        'created_at' => Carbon::now()
                    ]);
                    Mail::to($userDetails->email)->send(new JoinCssdFamily($userDetails, $createdBy, url('user/password/reset', $token), 'Operation Theatre User'));
                    break;

                case UserConstants::USER_TYPE_STERILIZATION:
                    $token =  Password::broker('sterilizations')->createToken($userDetails);
                    DB::table('sterilization_password_resets')->updateOrInsert([
                        'email' => $userDetails->email],[
                        'token' => bcrypt($token),
                        'created_at' => Carbon::now()
                    ]);
                    Mail::to($userDetails->email)->send(new JoinCssdFamily($userDetails, $createdBy, url('sterilization/password/reset', $token),'Sterilization User'));
                    break;

                case UserConstants::USER_TYPE_COLLECTION:
                    $token =  Password::broker('collections')->createToken($userDetails);
                    DB::table('collection_password_resets')->updateOrInsert([
                        'email' => $userDetails->email],[
                        'token' => bcrypt($token),
                        'created_at' => Carbon::now()
                    ]);
                    Mail::to($userDetails->email)->send(new JoinCssdFamily($userDetails, $createdBy, url('collection/password/reset', $token),'Collection User'));
                    break;

                default:
                    break;
            }
        } catch (Exception $ex) {
            Toastr::error('Error while sending welcome email, Please do contact support team');
        }
    }

}

