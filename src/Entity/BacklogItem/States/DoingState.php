<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\Observer\NotificationManager;
use App\Entity\Observer\UserRole;

class DoingState implements BacklogItemState
{

    public function __construct(
        private readonly NotificationManager $notificationManager
    )
    {
    }

    public function progressState(): BacklogItemState
    {
        return new ReadyForTestingState($this->notificationManager);
    }

    public function regressState(): BacklogItemState
    {
        $this->notificationManager->notify(UserRole::SCRUM_MASTER, "A user moved backlogitem back to todo");
        return new TodoState($this->notificationManager);
    }
}
