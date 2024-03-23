<?php

namespace App\Domain\Sprint\States\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\PartialProduct\PartialProductSprintState;

class ReleaseCreatedState implements ReleaseSprintState
{
    private NotificationManager $manager;

    public function __construct(NotificationManager $manager, private Pipeline $pipeline)
    {
        $this->manager = $manager;
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function progressSprint(NotificationManager $manager, Pipeline $pipeline): ReleaseSprintState
    {
        return new ReleaseInProgressState($this->manager, $this->pipeline);
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

    public function getPipeline(): Pipeline
    {
        throw new ModificationNotAllowedException('Pipeline is not available');
    }

    public function setPipeline(Pipeline $pipeline): void
    {
        $this->pipeline = $pipeline;
    }
}
