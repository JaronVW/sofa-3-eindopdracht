<?php

namespace App\Domain\Sprint;

use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\EmailListenerAdapter;
use App\Domain\Observer\NotificationManager;
use App\Domain\Observer\SlackListenerAdapter;
use App\Domain\Sprint\States\Release\ReleaseCreatedState;
use App\Domain\Sprint\States\Release\ReleaseSprintState;
use App\Domain\Users\ProductOwner;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;

class ReleaseSprint extends Sprint
{
    private NotificationManager $manager;
    public function __construct(string $name, DateTimeImmutable $startDate, DateTimeImmutable $endDate, ScrumMaster $scrumMaster, ?ProductOwner $productOwner = null)
    {
        parent::__construct($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->manager = new NotificationManager();


        $this->state = new ReleaseCreatedState($this->manager);

        $this->manager->subscribe($this->scrumMaster->getRole(), new SlackListenerAdapter($this->name, "sprint status"));
        $this->manager->subscribe($this->scrumMaster->getRole(), new EmailListenerAdapter($this->name, "sprint status"));

        if ($this->productOwner !== null) {
            $this->manager->subscribe($this->productOwner->getRole(), new SlackListenerAdapter($this->name, "sprint status"));
            $this->manager->subscribe($this->productOwner->getRole(), new EmailListenerAdapter($this->name, "sprint status"));
        }
    }

    public function progressSprint(): void
    {
        $this->state = $this->state->progressSprint($this->manager);
    }

    public function cancelSprint(): void
    {
        $this->state = $this->state->cancelSprint();
    }

    /**
     * @throws PipelineRestartNotAllowedException
     */
    public function retryPipeline(): void
    {
        $this->state = $this->state->retryPipeline();
    }

}
