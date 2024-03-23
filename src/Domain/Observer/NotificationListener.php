<?php

namespace App\Domain\Observer;


interface NotificationListener
{
    public function sendNotification(string $message);
}
