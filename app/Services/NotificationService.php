<?php


namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Carbon;
use App\Http\Constants\NotificationConstants;


class NotificationService
{

    /**
     * send Notification
     *
     * @param  mixed $message
     * @param  mixed $sender_id
     * @param  mixed $sender_type
     * @param  mixed $receiver_id
     * @param  mixed $receiver_type
     * @param  mixed $postUrl
     * @return void
     */
    public function sendNotification($message, $sender_id, $sender_type, $receiver_id, $receiver_type, $postUrl = null)
    {
        return Notification::create([
            'message' => $message,
            'sender_id' => $sender_id,
            'sender_type' => $sender_type,
            'receiver_id' => $receiver_id,
            'receiver_type' => $receiver_type,
            'seen' => NotificationConstants::NOTIFICATION_NOT_SEEN,
            'post_url' => ($postUrl !=null) ? parse_url($postUrl, PHP_URL_PATH) : $postUrl,
        ]);
    }



    /**
     * get Notifications
     *
     * @param  mixed $userId
     * @param  mixed $userType
     * @return void
     */
    public function getNotifications($userId, $userType)
    {
        $notifications = [];

        $notifications = Notification::where('receiver_type', $userType)
            ->where('receiver_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(NotificationConstants::PAGINATION_LIMIT);

        foreach ($notifications as $key => $value) {
            $value->received_at = Carbon::parse($value->created_at)->diffInDays(Carbon::now()) > 1 ? Carbon::parse($value->created_at)->format('j M Y , g:ia') : Carbon::parse($value->created_at)->diffForHumans();
        }

        $notifications->unread_count = Notification::where('receiver_type', $userType)
            ->where('receiver_id', $userId)
            ->where('seen', NotificationConstants::NOTIFICATION_NOT_SEEN)
            ->orderByDesc('created_at')
            ->count();

        return $notifications;
    }
}
