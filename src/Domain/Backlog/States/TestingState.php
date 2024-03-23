<?php

namespace App\Domain\Backlog\States;

use App\Domain\Observer\NotificationManager;

class TestingState implements BacklogItemState
{

    public function __construct(
        private NotificationManager $notificationManager
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
