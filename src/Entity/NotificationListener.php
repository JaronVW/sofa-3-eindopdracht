<?php

namespace App\Entity;

use App\Entity\BacklogItem\Observer\Notification;

interface NotificationListener
{
    public function sendNotification(string $message);
}
