<?php

namespace App\Domain\BacklogItem\States;

use App\Domain\Exceptions\StateTransitionInvalidException;
use App\Domain\Observer\NotificationManager;

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
