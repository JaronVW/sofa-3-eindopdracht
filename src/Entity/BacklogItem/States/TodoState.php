<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;
use App\Entity\Exceptions\StateTransitionInvalidException;

class TodoState implements BacklogItemState
{

    public function __construct(
        private BacklogItemNotificationManager $notificationManager
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
