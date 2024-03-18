<?php

namespace App\Entity\Sprint;

use App\Entity\Backlog;
use App\Entity\BacklogItem\States\BacklogItem;
use App\Entity\Sprint\States\SprintState;

abstract class Sprint
{
    private array $backlogItems;
    private Backlog $backlog;
    public function __construct(
        private SprintState $state
    )
    {
        $this->backlog = new Backlog();
        $this->backlogItems = [];
    }




}
