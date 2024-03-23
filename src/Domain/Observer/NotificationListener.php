<?php

namespace App\Domain\Observer;

use App\Domain\Backlog\Observer\Notification;

interface NotificationListener
{
    public function sendNotification(string $message);
}
