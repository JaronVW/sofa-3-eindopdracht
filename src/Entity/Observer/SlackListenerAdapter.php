<?php

namespace App\Entity\Observer;

use App\Entity\Libraries\SlackLibrary;
use App\Entity\NotificationListener;

class SlackListenerAdapter implements NotificationListener
{
    public function __construct(
        private SlackLibrary $slackLibrary,
        private string       $channel,
        private string       $topic,
    )
    {
    }

    public function sendNotification(string $message): void
    {
        $message = sprintf("%s %s %s", $this->channel, $this->topic, $message);
        $this->slackLibrary->sendSlack($message);
    }
}
