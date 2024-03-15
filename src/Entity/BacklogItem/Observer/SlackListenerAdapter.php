<?php

namespace App\Entity\BacklogItem\Observer;

use App\Entity\Libraries\SlackLibrary;

class SlackListenerAdapter
{
    public function __construct(
        private SlackLibrary $slackLibrary
    )
    {
    }
}
