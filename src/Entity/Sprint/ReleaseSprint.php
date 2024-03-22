<?php

namespace App\Entity\Sprint;

use App\Entity\Exceptions\PipelineFailedException;
use App\Entity\Exceptions\PipelineRestartNotAllowedException;
use App\Entity\Observer\EmailListenerAdapter;
use App\Entity\Observer\NotificationManager;
use App\Entity\Observer\SlackListenerAdapter;
use App\Entity\Sprint\States\Release\ReleaseCancelledState;
use App\Entity\Sprint\States\Release\ReleaseCreatedState;
use App\Entity\Sprint\States\Release\ReleaseFinishedState;
use App\Entity\Sprint\States\SprintState;
use App\Entity\Users\ProductOwner;
use App\Entity\Users\ScrumMaster;
use DateTimeImmutable;

class ReleaseSprint extends Sprint
{

    private NotificationManager $manager;
    public function __construct(string $name, DateTimeImmutable $startDate, DateTimeImmutable $endDate, ScrumMaster $scrumMaster, ?ProductOwner $productOwner = null)
    {
        parent::__construct($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->state = new ReleaseCreatedState();
        $this->manager = new NotificationManager();


        $this->manager->subscribe($this->scrumMaster->getRole(), new SlackListenerAdapter($this->name, "sprint status"));
        $this->manager->subscribe($this->scrumMaster->getRole(), new EmailListenerAdapter($this->name, "sprint status"));

        if ($this->productOwner !== null) {
            $this->manager->subscribe($this->productOwner->getRole(), new SlackListenerAdapter($this->name, "sprint status"));
            $this->manager->subscribe($this->productOwner->getRole(), new EmailListenerAdapter($this->name, "sprint status"));
        }
    }

    public function progressSprint(): void
    {
        $this->state = $this->state->finishSprint();
    }

    public function cancelSprint(): void
    {
        $this->state = $this->state->cancelSprint();
    }

    /**
     */
    public function retryPipeline(): void
    {
        $this->state = $this->state->retryPipeline();
    }

}
