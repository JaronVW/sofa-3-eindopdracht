<?php

namespace App\Domain\Backlog\States;

use App\Domain\Exceptions\StateTransitionInvalidException;
use App\Domain\Observer\NotificationManager;

class TodoState implements BacklogItemState
{

    public function __construct(
        private NotificationManager $notificationManager
    )
    {
    }

    public function progressState(): BacklogItemState
    {
       return new DoingState($this->notificationManager) ;
    }

    public function regressState(): BacklogItemState
    {
        throw new StateTransitionInvalidException();
    }
}
