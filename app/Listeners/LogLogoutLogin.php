<?php

namespace App\Listeners;

use App\Http\Constants\AuthConstants;

use App\Models\CollectionLoginLog;
use App\Models\SterilizationLoginLog;
use App\Models\UserLoginLog;
use App\Models\AdminLoginLog;

use Carbon\Carbon;
use App\Http\Helpers\Core\Server;
use Illuminate\Auth\Events\Logout;


class LogLogoutLogin
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $logData = [
            'status' => AuthConstants::LOGIN_LOGOUT,
            'logged_at' => Carbon::now()->toDateTimeString(),
            'remote_address' => Server::remoteAddress(),
//            'note' => serialize($event->user->email),
            'header' => Server::userAgent(),
        ];

        if($event->user != null) {
            $eventTable = new $event->user();
            switch ($eventTable->getTableName()) {

                case 'admin.':
                    $logData['admin_id'] = $event->user->id;
                    AdminLoginLog::create($logData);
                    break;

                case 'user.':
                    $logData['user_id'] = $event->user->id;
                    UserLoginLog::create($logData);
                   break;

                default:
                    break;
            }
        }
    }
}
