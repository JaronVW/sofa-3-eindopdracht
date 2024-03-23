<?php

namespace App\Domain\Libraries;

class SlackLibrary
{
    public function sendSlack(string $message): string
    {
        echo "Sent slack";
        return "Sent slack";
    }
}
