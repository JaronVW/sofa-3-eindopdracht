<?php

namespace App\Domain;

use App\Domain\BacklogItem\Observer\Notification;

interface NotificationListener
{
    public function sendNotification(string $message);
}
