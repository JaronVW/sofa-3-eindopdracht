<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\BacklogActivity;
use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;
use App\Entity\BacklogItem\Observer\UserRole;
use App\Entity\User;

class BacklogItem
{

    private BacklogItemState $state;

    /**
     * @var array<int,BacklogActivity>
     */
    private array  $backlogActivities;

    public function __construct(
        private string $title,
        private string $description,
        private BacklogItemNotificationManager $notificationManager,
        private User $developer
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


}
