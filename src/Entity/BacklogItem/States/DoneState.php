<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\Exceptions\StateTransitionInvalidException;
use App\Entity\Observer\NotificationManager;

class DoneState implements BacklogItemState
{

    public function __construct(private NotificationManager $notificationManager)
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
