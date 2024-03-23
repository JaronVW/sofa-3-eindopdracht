<?php

namespace App\Domain\Backlog\States;

use App\Domain\Observer\NotificationManager;
use App\Domain\Users\UserRole;

final readonly class ReadyForTestingState implements BacklogItemState
{

    public function __construct(
        private NotificationManager $notificationManager
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
