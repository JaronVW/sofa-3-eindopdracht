<?php

namespace App\Entity\Observer;

use App\Entity\Libraries\SlackLibrary;
use App\Entity\NotificationListener;

class SlackListenerAdapter implements NotificationListener
{

    private SlackLibrary $slackLibrary;
    public function __construct(
        private string       $channel,
        private string       $topic,
    )
    {
        $this->slackLibrary = new SlackLibrary();
    }

    public function sendNotification(string $message): void
    {
        $message = sprintf("%s %s %s", $this->channel, $this->topic, $message);
        $this->slackLibrary->sendSlack($message);
    }
}
