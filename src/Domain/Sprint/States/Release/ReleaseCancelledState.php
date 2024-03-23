<?php

namespace App\Domain\Sprint\States\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Users\UserRole;

class ReleaseCancelledState implements ReleaseSprintState
{
    public function __construct(private NotificationManager $notificationManager)
    {
        $this->notificationManager->notify(UserRole::SCRUM_MASTER,"Sprint is cancelled");
        $this->notificationManager->notify(UserRole::PRODUCT_OWNER,"Sprint is cancelled");
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function progressSprint(NotificationManager $manager, Pipeline $pipeline): ReleaseSprintState
    {
        throw new ModificationNotAllowedException('Sprint is already cancelled');
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function cancelSprint()
    {
        throw new ModificationNotAllowedException('Sprint is already cancelled');
    }

    public function retryPipeline()
    {
        throw new ModificationNotAllowedException('Sprint is already cancelled');
    }

    public function getPipeline(): Pipeline
    {
        throw new ModificationNotAllowedException('Sprint is already cancelled');
    }

    public function setPipeline(Pipeline $pipeline): void
    {
        throw new ModificationNotAllowedException('Sprint is already cancelled');
    }
}
