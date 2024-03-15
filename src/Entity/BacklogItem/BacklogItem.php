<?php

namespace App\Entity\BacklogItem;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;
use App\Entity\BacklogItem\States\BacklogItemState;

class BacklogItem
{
    public function __construct(
        private BacklogItemNotificationManager $notificationManager,
        /**
         * @var array<int,BacklogActivity>
         */
        private array                          $backlogActivities,
        private BacklogItemState               $state
    )
    {

    }
}
