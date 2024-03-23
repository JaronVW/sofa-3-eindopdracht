<?php

namespace App\Domain\Observer;

use App\Domain\Libraries\EmailLibrary;

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

    public function sendNotification(string $message): void
    {
       $message = sprintf("%s %s %s", $this->email, $this->topic, $message);
       $this->emailLibrary->sendEmail($message);
    }
}
