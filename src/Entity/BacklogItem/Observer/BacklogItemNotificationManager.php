<?php

namespace App\Entity\BacklogItem\Observer;

use App\Entity\NotificationListener;

class BacklogItemNotificationManager
{
    /**
     * @param array<int,NotificationListener> $listeners
     */
    public function __construct(
        private array $listeners
    )
    {
    }
}
