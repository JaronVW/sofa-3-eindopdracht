<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;
use App\Entity\BacklogItem\Observer\UserRole;
use App\Entity\Exceptions\StateTransitionInvalidException;

class DoingState implements BacklogItemState
{

    public function __construct(
        private readonly BacklogItemNotificationManager $notificationManager
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
