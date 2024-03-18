<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;
use App\Entity\BacklogItem\Observer\UserRole;

final readonly class ReadyForTestingState implements BacklogItemState
{

    public function __construct(
        private BacklogItemNotificationManager $notificationManager
    )
    {
        $this->notificationManager->notify(UserRole::TESTER, "READY FOR TESTING");
    }

    public function progressState(): BacklogItemState
    {
        return new TestingState($this->notificationManager);
    }

    public function regressState(): BacklogItemState
    {
        return new TodoState($this->notificationManager);
    }
}
