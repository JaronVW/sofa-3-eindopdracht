<?php

namespace App\Entity\BacklogItem\Observer;

use App\Entity\Libraries\EmailLibrary;

class EmailListenerAdapter
{
    public function __construct(
        private EmailLibrary $emailLibrary
    )
    {
    }
}
