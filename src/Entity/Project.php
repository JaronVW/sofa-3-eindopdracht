<?php

namespace App\Entity;

class Project
{
    public function __construct(
        private Backlog $backlog
    )
    {
    }
}
