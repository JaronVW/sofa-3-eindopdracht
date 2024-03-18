<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;

class TestingState implements BacklogItemState
{

    public function __construct(
        private BacklogItemNotificationManager $notificationManager
    )
    {
    }

    public function progressState(): BacklogItemState
    {
        return new TestedState($this->notificationManager);
    }

    public function regressState(): BacklogItemState
    {
        return new TodoState($this->notificationManager);
    }
}
