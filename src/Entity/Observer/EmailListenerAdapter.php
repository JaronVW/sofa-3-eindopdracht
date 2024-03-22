<?php

namespace App\Entity\Observer;

use App\Entity\Libraries\EmailLibrary;
use App\Entity\NotificationListener;

class EmailListenerAdapter implements NotificationListener
{

    private EmailLibrary $emailLibrary;
    public function __construct(
        private string $email,
        private string $topic,
    )
    {
        $this->emailLibrary = new EmailLibrary();
    }

    public function sendNotification(string $message)
    {
       $message = sprintf("%s %s %s", $this->email, $this->topic, $message);
       $this->emailLibrary->sendEmail($message);
    }
}
