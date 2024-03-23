<?php

namespace App\Domain\Sprint;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\EmailListenerAdapter;
use App\Domain\Observer\NotificationManager;
use App\Domain\Observer\SlackListenerAdapter;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\PartialProduct\PartialProductCreatedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductSprintState;
use App\Domain\Sprint\States\Release\ReleaseCreatedState;
use App\Domain\Sprint\States\Release\ReleaseSprintState;
use App\Domain\Users\ProductOwner;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;

class ReleaseSprint extends Sprint
{
    private ReleaseSprintState $state;
    private NotificationManager $manager;
    public function __construct(string $name, DateTimeImmutable $startDate, DateTimeImmutable $endDate, ScrumMaster $scrumMaster, ?ProductOwner $productOwner = null)
    {
        parent::__construct($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->manager = new NotificationManager();


        $this->state = new ReleaseCreatedState($this->manager, $this->pipeline);

        $this->manager->subscribe($this->scrumMaster->getRole(), new SlackListenerAdapter($this->name, "sprint status"));
        $this->manager->subscribe($this->scrumMaster->getRole(), new EmailListenerAdapter($this->name, "sprint status"));

        if ($this->productOwner !== null) {
            $this->manager->subscribe($this->productOwner->getRole(), new SlackListenerAdapter($this->name, "sprint status"));
            $this->manager->subscribe($this->productOwner->getRole(), new EmailListenerAdapter($this->name, "sprint status"));
        }
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function progressSprint(): void
    {
        $this->state = $this->state->progressSprint($this->manager, $this->pipeline);
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

    /**
     * @throws ModificationNotAllowedException
     */
    protected function modifySprintAllowed(): bool
    {
        if (($this->state instanceof ReleaseCreatedState) || $this->pipeline->isPipeLineBusy()) {
            return true;
        }
        throw new ModificationNotALlowedException();

    }

    public function getState(): ReleaseSprintState
    {
        return $this->state;
    }

    public function setState(ReleaseSprintState| PartialProductSprintState $state): void
    {
        $this->state = $state;
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setPipeline(Pipeline $pipeline): void
    {
        if ($this->modifySprintAllowed()) {
            $this->state->get = $pipeline;
        }
    }

}
