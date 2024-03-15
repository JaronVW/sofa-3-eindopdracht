<?php

namespace App\Entity\Sprint;

use App\Entity\Sprint\States\SprintState;

abstract class Sprint
{
    public function __construct(
        private SprintState $state
    )
    {
    }
}
