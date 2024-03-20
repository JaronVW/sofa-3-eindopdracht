<?php

namespace App\Entity\BacklogItem;

use App\Entity\BacklogActivity;
use App\Entity\BacklogItem\States\BacklogItemState;
use App\Entity\BacklogItem\States\TodoState;
use App\Entity\Observer\NotificationManager;
use App\Entity\User;

class BacklogItem
{

    private BacklogItemState $state;

    /**
     * @var array<int,BacklogActivity>
     */
    private array  $backlogActivities;

    public function __construct(
        public readonly string               $title,
        public readonly string               $description,
        private readonly NotificationManager $notificationManager,
        private ?User                        $developer
    )
    {
        $this->state = new TodoState($this->notificationManager);
        $this->backlogActivities = [];
    }

    public function getBacklogActivities(): array
    {
        return $this->backlogActivities;
    }

    public function addBacklogActivity(BacklogActivity $backlogActivity)
    {
        $this->backlogActivities[] = $backlogActivity;
    }

    public function getDeveloper(): ?User
    {
        return $this->developer;
    }

    public function setDeveloper(?User $developer): void
    {
        $this->developer = $developer;
    }


}
