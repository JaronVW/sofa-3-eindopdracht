<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\Observer\NotificationManager;

class TestedState implements BacklogItemState
{

    public function __construct(private NotificationManager $notificationManager)
    {
    }

    public function progressState(): BacklogItemState
    {
        return new DoneState($this->notificationManager);
    }

    public function regressState(): BacklogItemState
    {
        return new TestingState($this->notificationManager);
    }

    public function resetState(): TodoState
    {
        return new TodoState($this->notificationManager);
    }
}
