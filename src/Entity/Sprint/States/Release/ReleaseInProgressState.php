<?php

namespace App\Entity\Sprint\States\Release;

use App\Entity\Exceptions\PipelineFailedException;
use App\Entity\Exceptions\PipelineRestartNotAllowedException;
use App\Entity\Observer\EmailListenerAdapter;
use App\Entity\Observer\NotificationManager;
use App\Entity\Observer\SlackListenerAdapter;
use App\Entity\Observer\UserRole;
use App\Entity\Pipeline\Pipeline;
use App\Entity\Sprint\States\SprintState;

class ReleaseInProgressState implements SprintState
{

    private NotificationManager $manager;
    private Pipeline $pipeline;

    public function __construct(NotificationManager $manager)
    {
        $this->manager = $manager;
        $this->pipeline = new Pipeline();
    }

    public function finishSprint(): SprintState
    {
        try {
            $this->pipeline->execute();
        } catch (PipelineFailedException $e) {
            $this->manager->notify(UserRole::SCRUM_MASTER, "Pipeline failed, retry running the pipeline");
            return $this;
        }
        return  new ReleaseFinishedState($this->manager);
    }

    public function cancelSprint(): SprintState
    {
        return new ReleaseCancelledState($this->manager);
    }

    /**
     * @throws PipelineRestartNotAllowedException
     */
    public function retryPipeline(): SprintState
    {
        if ($this->pipeline->didPipeLineFail()) {
            $this->finishSprint();
            return $this;
        }
        throw new PipelineRestartNotAllowedException("Pipeline did not fail");
    }

}
