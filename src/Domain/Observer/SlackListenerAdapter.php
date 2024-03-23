<?php

namespace App\Domain\Observer;

use App\Domain\Libraries\SlackLibrary;

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
