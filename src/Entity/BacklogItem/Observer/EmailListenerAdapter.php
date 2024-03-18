<?php

namespace App\Entity\BacklogItem\Observer;

use App\Entity\Libraries\EmailLibrary;
use App\Entity\NotificationListener;

class EmailListenerAdapter implements NotificationListener
{
    public function __construct(
        private EmailLibrary $emailLibrary,
        private string $email,
        private string $topic,
    )
    {
    }

    public function sendNotification(string $message)
    {
       $message = sprintf("%s %s %s", $this->email, $this->topic, $message);
       $this->emailLibrary->sendEmail($message);
    }
}
