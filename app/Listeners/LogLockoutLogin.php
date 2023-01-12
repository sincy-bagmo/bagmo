<?php

namespace App\Listeners;

use App\Models\CollectionLoginLog;
use App\Models\SterilizationLoginLog;
use App\Models\UserLoginLog;
use App\Models\AdminLoginLog;

use App\Http\Helpers\Core\Server;
use Illuminate\Auth\Events\Lockout;
use App\Http\Constants\AuthConstants;
use Carbon\Carbon;
use Route;


class LogLockoutLogin
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
     * @param  Lockout  $event
     * @return void
     */
    public function handle(Lockout $event)
    {
        if (isset($event->credentials)) {
            $logData = [
                'status' => AuthConstants::LOGIN_LOCKOUT,
                'logged_at' => Carbon::now()->toDateTimeString(),
                'remote_address' => Server::remoteAddress(),
                'note' => serialize($event->credentials),
                'header' => Server::userAgent(),
            ];

            switch (Route::currentRouteName()) {

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
        } else {
            abort(419);
        }
    }
}
