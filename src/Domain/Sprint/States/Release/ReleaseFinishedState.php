<?php

namespace App\Domain\Sprint\States\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Users\UserRole;

class ReleaseFinishedState implements ReleaseSprintState
{

        const string ERROR = 'Sprint is already finished';
        public function __construct(
            private readonly NotificationManager $notificationManager
        )
        {

            $this->notificationManager->notify(UserRole::SCRUM_MASTER,"Sprint is finished");
            $this->notificationManager->notify(UserRole::PRODUCT_OWNER,"Sprint is finished");
        }


    /**
     * @throws ModificationNotAllowedException
     */
    public function progressSprint(NotificationManager $manager, Pipeline $pipeline): ReleaseSprintState
    {
        throw new ModificationNotAllowedException(self::ERROR);
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function cancelSprint()
    {
        throw new ModificationNotAllowedException(self::ERROR);
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function retryPipeline()
    {
        throw new ModificationNotAllowedException(self::ERROR);
    }

    public function getPipeline(): Pipeline
    {
        throw new ModificationNotAllowedException(self::ERROR);
    }

    public function setPipeline(Pipeline $pipeline): void
    {
        throw new ModificationNotAllowedException(self::ERROR);
    }
}
