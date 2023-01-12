<?php


namespace App\Http\Helpers\Utilities;

use App\Http\Constants\AuthConstants;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AuthMessages
{

    public static function getLoginStatus($status = AuthConstants::LOGIN_SUCCESS)
    {
        $format = '<span class="badge %s">%s</span>';
        $message = '';
        switch ($status) {

            case AuthConstants::LOGIN_FAILED:
                $message = sprintf($format, 'badge badge-warning',AuthConstants::LOGIN_MESSAGE[AuthConstants::LOGIN_FAILED]);
                break;

            case AuthConstants::LOGIN_SUCCESS:
                $message = sprintf($format, 'badge bg-success',AuthConstants::LOGIN_MESSAGE[AuthConstants::LOGIN_SUCCESS]);
                break;

            case AuthConstants::LOGIN_LOCKOUT:
                $message = sprintf($format, 'badge badge-danger',AuthConstants::LOGIN_MESSAGE[AuthConstants::LOGIN_LOCKOUT]);
                break;

            case AuthConstants::LOGIN_LOGOUT:
                $message = sprintf($format, 'badge badge-info',AuthConstants::LOGIN_MESSAGE[AuthConstants::LOGIN_LOGOUT]);
                break;

            default:
                break;
        }
        return $message;
    }

}
