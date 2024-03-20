<?php

namespace App\Entity;

use App\Entity\BacklogItem\BacklogItem;

class Backlog
{
    /**
     * @var array<int,BacklogItem>
     */
    private array $backlogItems;

    public function __construct()
    {
        $this->backlogItems = [];
    }


    public function getBacklogItems(): array
    {
        return $this->backlogItems;
    }

    public function addBacklogItem(BacklogItem $backlogItem)
    {
        $this->backlogItems[] = $backlogItem;
    }
}
