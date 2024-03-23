<?php

namespace App\Domain;

use App\Domain\BacklogItem\BacklogItem;

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

    public function addBacklogItem(BacklogItem $backlogItem): void
    {
        $this->backlogItems[] = $backlogItem;
    }

    public function removeBacklogItem(BacklogItem $backlogItem): void
    {
        $key = array_search($backlogItem, $this->backlogItems);
        if ($key !== false) {
            unset($this->backlogItems[$key]);
        }
    }
}
