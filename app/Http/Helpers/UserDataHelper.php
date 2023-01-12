<?php


namespace App\Http\Helpers;

use App\Http\Constants\FileDestinations;
use App\Http\Helpers\Core\FileManager;

use App\Models\Admin;
use App\Models\Sterilization;
use App\Models\SterilizationSubUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UserDataHelper
{

    public static function getAdminUserName($userId)
    {
        $result = '---';
        $userDetails = Admin::where('id', $userId)->select('first_name', 'last_name')->first();
        if (! is_null($userDetails)) {
            $result = $userDetails->first_name . ' ' . $userDetails->last_name;
        }
        return $result;
    }

    public static function getOtUserName($userId)
    {
        $result = '---';
        $userDetails = User::where('id', $userId)->select('first_name', 'last_name')->first();
        if (! is_null($userDetails)) {
            $result = $userDetails->first_name . ' ' . $userDetails->last_name;
        }
        return $result;
    }

    public static function getSterilizationUserName($userId)
    {
        $result = '---';
        $userDetails = Sterilization::where('id', $userId)->select('first_name', 'last_name')->first();
        if (! is_null($userDetails)) {
            $result = $userDetails->first_name . ' ' . $userDetails->last_name;
        }
        return $result;
    }

    public static function getAdminUserImage($userId)
    {
        $file = asset('images/default-user.png');
        $filename = Admin::where('id', $userId)->value('profile_image');
        if (! is_null($filename)) {
            if (FileManager::checkFileExist($filename, FileDestinations::PROFILE_ADMIN)) {
                $file = FileManager::getFileUrl($filename, FileDestinations::PROFILE_ADMIN);
            }
        }
        return $file;
    }

    public static function getOtUserImage($userId)
    {
        $file = asset('images/default-user.png');
        $filename = User::where('id', $userId)->value('profile_image');
        if (! is_null($filename)) {
            if (FileManager::checkFileExist($filename, FileDestinations::PROFILE_OT_USER)) {
                $file = FileManager::getFileUrl($filename, FileDestinations::PROFILE_OT_USER);
            }
        }
        return $file;
    }

    public static function getSterilizationUserImage($userId)
    {
        $file = asset('images/default-user.png');
        $filename = Sterilization::where('id', $userId)->value('profile_image');
        if (! is_null($filename)) {
            if (FileManager::checkFileExist($filename, FileDestinations::PROFILE_STERILIZATION_USER)) {
                $file = FileManager::getFileUrl($filename, FileDestinations::PROFILE_STERILIZATION_USER);
            }
        }
        return $file;
    }
}
