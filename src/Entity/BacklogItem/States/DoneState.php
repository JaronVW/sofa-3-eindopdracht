<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;
use App\Entity\Exceptions\StateTransitionInvalidException;

class DoneState implements BacklogItemState
{

    public function __construct(private BacklogItemNotificationManager $notificationManager)
    {
    }

    public function progressState(): BacklogItemState
    {
        throw new StateTransitionInvalidException;
    }

    public function regressState(): BacklogItemState
    {
        return new ReadyForTestingState($this->notificationManager);
    }
}
