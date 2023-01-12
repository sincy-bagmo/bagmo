<?php

namespace App\Http\Helpers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SuperAdmin;
use App\Models\Supervisor;
use App\Models\OfficeStaff;
use App\Models\BackOfficeStaff;
use App\Http\Constants\UserConstants;
use App\Services\NotificationService;

class NotificationHelper
{

    /**
     * getNotifications
     *
     * @param  mixed $userId
     * @param  mixed $userType
     * @return void
     */
    public static function getNotifications($userId, $userType)
    {

        return (new NotificationService())->getNotifications($userId, $userType);
    }
    /**
     * getNotificationSender
     *
     * @param  mixed $userId
     * @param  mixed $userType
     * @return void
     */
    public static function getNotificationSendBy($userId, $userType)
    {

        $notificationSendBy = '';
        switch ($userType) {
            case UserConstants::USER_TYPE_OFFICE_STAFF:
                $notificationSendBy = OfficeStaff::where('id', $userId)->pluck('first_name', 'last_name')->first();
                break;

            case UserConstants::USER_TYPE_BACK_OFFICE_STAFF:
                $notificationSendBy = BackOfficeStaff::where('id', $userId)->pluck('first_name', 'last_name')->first();
                break;

            case UserConstants::USER_TYPE_SUPER_ADMIN:
                $notificationSendBy = SuperAdmin::where('id', $userId)->pluck('first_name', 'last_name')->first();
                break;

            case UserConstants::USER_TYPE_ADMIN:
                $notificationSendBy = Admin::where('id', $userId)->pluck('first_name', 'last_name')->first();
                break;

            case UserConstants::USER_TYPE_SUPERVISOR:
                $notificationSendBy = Supervisor::where('id', $userId)->pluck('first_name', 'last_name')->first();
                break;

            case UserConstants::USER_TYPE_TEACHER:
                $notificationSendBy = Teacher::where('id', $userId)->pluck('first_name', 'last_name')->first();
                break;

            case UserConstants::USER_TYPE_STUDENT:
                $notificationSendBy = Student::where('id', $userId)->pluck('first_name', 'last_name')->first();
                break;

            default:
                break;
        }
        return $notificationSendBy;
    }
}
