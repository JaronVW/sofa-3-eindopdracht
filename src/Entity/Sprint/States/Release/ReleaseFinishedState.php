<?php

namespace App\Entity\Sprint\States\Release;

use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Observer\NotificationManager;
use App\Entity\Observer\UserRole;
use App\Entity\Sprint\States\SprintState;

class ReleaseFinishedState implements SprintState
{

        public function __construct(
            private readonly NotificationManager $notificationManager
        )
        {

            $this->notificationManager->notify(UserRole::SCRUM_MASTER,"Sprint is finished");
            $this->notificationManager->notify(UserRole::PRODUCT_OWNER,"Sprint is finished");
        }


    public function finishSprint()
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
