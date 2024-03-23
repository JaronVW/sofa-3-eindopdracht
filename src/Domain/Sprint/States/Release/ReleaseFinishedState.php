<?php

namespace App\Domain\Sprint\States\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Users\UserRole;

class ReleaseFinishedState implements ReleaseSprintState
{

        public function __construct(
            private readonly NotificationManager $notificationManager
        )
        {

            $this->notificationManager->notify(UserRole::SCRUM_MASTER,"Sprint is finished");
            $this->notificationManager->notify(UserRole::PRODUCT_OWNER,"Sprint is finished");
        }


    public function progressSprint()
    {
        throw new ModificationNotAllowedException('Sprint is already finished');
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function cancelSprint()
    {
        throw new ModificationNotAllowedException('Sprint is already finished');
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function retryPipeline()
    {
        throw new ModificationNotAllowedException('Sprint is already finished');
    }
}
