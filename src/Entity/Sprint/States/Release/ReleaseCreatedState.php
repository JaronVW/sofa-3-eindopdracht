<?php

namespace App\Entity\Sprint\States\Release;

use App\Entity\Observer\NotificationManager;
use App\Entity\Sprint\States\SprintState;

class ReleaseCreatedState implements SprintState
{
    private NotificationManager $manager;
    public function __construct(NotificationManager $manager)
    {
        $this->manager = $manager;
    }

    public function finishSprint()
    {
        // TODO: Implement finishSprint() method.
    }

    public function cancelSprint(): SprintState
    {
        return new ReleaseCancelledState($this->manager);
    }

    public function retryPipeline()
    {
        // TODO: Implement retryPipeline() method.
    }
}
