<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;

class BacklogItem
{

    private BacklogItemState $state;

    public function __construct(
        /**
         * @var array<int,BacklogActivity>
         */
        private array  $backlogActivities,
        private string $title,
        private string $description,
        private BacklogItemNotificationManager $notificationManager
    )
    {
        $this->state = new TodoState($this->notificationManager);
    }


}
