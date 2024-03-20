<?php

namespace App\Entity\Sprint\States\Release;

use App\Entity\Observer\NotificationManager;
use App\Entity\Observer\UserRole;
use App\Entity\Sprint\States\SprintState;

class ReleaseCancelledState implements SprintState
{
    public function __construct(private NotificationManager $notificationManager)
    {
        $this->notificationManager->notify(UserRole::SCRUM_MASTER,"Sprint is cancelled");
        $this->notificationManager->notify(UserRole::PRODUCT_OWNER,"Sprint is cancelled");
    }
}
