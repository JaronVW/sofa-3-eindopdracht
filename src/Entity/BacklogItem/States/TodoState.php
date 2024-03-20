<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\Exceptions\StateTransitionInvalidException;
use App\Entity\Observer\NotificationManager;

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
