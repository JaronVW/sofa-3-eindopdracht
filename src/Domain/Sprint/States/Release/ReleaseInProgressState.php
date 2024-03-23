<?php

namespace App\Domain\Sprint\States\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineFailedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Users\UserRole;
use App\Domain\Pipeline\Pipeline;
use Exception;

class ReleaseInProgressState implements ReleaseSprintState
{

    private NotificationManager $manager;

    public function __construct(NotificationManager $manager, private Pipeline $pipeline)
    {
        $this->manager = $manager;
    }

    public function progressSprint(NotificationManager $manager , Pipeline $pipeline): ReleaseSprintState
    {
        try {
            $this->pipeline->execute();
        } catch (PipelineFailedException $e) {
            $this->manager->notify(UserRole::SCRUM_MASTER, "Pipeline failed, retry running the pipeline");
            echo "Pipeline failed\n";
            return $this;
        }
        echo "Pipeline finished\n";
        return  new ReleaseFinishedState($this->manager);
    }

    public function cancelSprint(): ReleaseSprintState
    {
        return new ReleaseCancelledState($this->manager);
    }

    /**
     * @throws PipelineRestartNotAllowedException
     */
    public function retryPipeline(): ReleaseSprintState
    {
        if ($this->pipeline->didPipeLineFail()) {
            return $this->progressSprint($this->manager, $this->pipeline);
        }
        throw new PipelineRestartNotAllowedException("Pipeline did not fail");
    }

    public function getPipeline(): Pipeline
    {
        return $this->pipeline;
    }

    public function setPipeline(Pipeline $pipeline): void
    {
        throw new ModificationNotAllowedException('Pipeline can not be changed');
    }
}
