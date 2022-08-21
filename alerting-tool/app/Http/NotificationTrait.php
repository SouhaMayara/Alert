<?php

namespace App\Http;

use App\Http\Controllers\Controller;

class NotificationTrait extends Controller
{
    public function sendSms($target, $message) {
        \Log::info("New Notification [SMS]: Target:" . $target . ', Message:' . $message);
    }

    public function sendPager($target, $message) {
        \Log::info("New Notification [Pager]: Target:" . $target . ', Message:' . $message);
    }

    public function sendEmail($target, $message) {
        \Log::info("New Notification [Email]: Target:" . $target . ', Message:' . $message);
    }
}
