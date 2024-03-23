<?php

namespace App\Domain\Sprint\States\Release;

use App\Domain\Exceptions\PipelineFailedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Users\UserRole;
use App\Domain\Pipeline\Pipeline;

class ReleaseInProgressState implements ReleaseSprintState
{

    private NotificationManager $manager;
    private Pipeline $pipeline;

    public function __construct(NotificationManager $manager)
    {
        $this->manager = $manager;
        $this->pipeline = new Pipeline();
    }

    public function progressSprint(): ReleaseSprintState
    {
        try {
            $this->pipeline->execute();
        } catch (PipelineFailedException $e) {
            $this->manager->notify(UserRole::SCRUM_MASTER, "Pipeline failed, retry running the pipeline");
            return $this;
        }
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
            $this->progressSprint();
            return $this;
        }
        throw new PipelineRestartNotAllowedException("Pipeline did not fail");
    }

}
