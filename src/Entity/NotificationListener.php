<?php

namespace App\Entity;

interface NotificationListener
{
    public function sendNotification();
}
