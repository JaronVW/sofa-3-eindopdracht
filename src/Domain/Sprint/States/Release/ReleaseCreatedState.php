<?php

namespace App\Domain\Sprint\States\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\NotificationManager;

class ReleaseCreatedState implements ReleaseSprintState
{
    private NotificationManager $manager;
    public function __construct(NotificationManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function progressSprint()
    {
        throw new ModificationNotAllowedException("Pipelines can't be started or restarted at this stage");
    }

    public function cancelSprint(): ReleaseSprintState
    {
        return new ReleaseCancelledState($this->manager);
    }

    /**
     * @throws PipelineRestartNotAllowedException
     */
    public function retryPipeline()
    {
        throw new PipelineRestartNotAllowedException("Pipelines can't be started or restarted at this stage");
    }
}
