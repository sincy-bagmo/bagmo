<?php

namespace App\Listeners;

use App\Models\AdminLoginLog;

use App\Http\Constants\AuthConstants;
use App\Http\Helpers\Core\Server;
use App\Models\Admin;
use App\Models\Collection;
use App\Models\CollectionLoginLog;
use App\Models\Sterilization;
use App\Models\SterilizationLoginLog;
use App\Models\User;
use App\Models\UserLoginLog;
use Illuminate\Auth\Events\Login;
use Carbon\Carbon;


class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $logData = [
            'status' => AuthConstants::LOGIN_SUCCESS,
            'logged_at' => Carbon::now()->toDateTimeString(),
            'remote_address' => Server::remoteAddress(),
            'note' => serialize($event->user->email),
            'header' => Server::userAgent(),
        ];
        $eventTable  = new $event->user();

        switch ($eventTable->getTableName()) {

            case Admin::getTableName():
                $logData['admin_id'] = $event->user->id;
                AdminLoginLog::create($logData);
                break;

            case User::getTableName():
                $logData['user_id'] = $event->user->id;
                UserLoginLog::create($logData);
                break;

            default :
                break;
        }

    }
}
