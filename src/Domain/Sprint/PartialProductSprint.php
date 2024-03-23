<?php

namespace App\Domain\Sprint;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\PartialProduct\PartialProductCancelledState;
use App\Domain\Sprint\States\PartialProduct\PartialProductCreatedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductFinishedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductInProgressState;
use App\Domain\Sprint\States\PartialProduct\PartialProductSprintState;
use App\Domain\Sprint\States\Release\ReleaseCreatedState;
use App\Domain\Sprint\States\Release\ReleaseSprintState;
use App\Domain\Users\ProductOwner;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;

class PartialProductSprint extends Sprint
{
    private PartialProductSprintState $state;
    public function __construct(string $name, DateTimeImmutable $startDate, DateTimeImmutable $endDate, ScrumMaster $scrumMaster, ?ProductOwner $productOwner = null)
    {
        parent::__construct($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->state = new PartialProductCreatedState();
    }

    public function progressSprint(): void
    {
        $this->state = $this->state->progressSprint();
    }

    public function cancelSprint(): void
    {
        $this->state = new PartialProductCancelledState();
    }

    /**
     * @throws ModificationNotAllowedException
     */
    protected function modifySprintAllowed(): bool
    {
        if (($this->state instanceof PartialProductCreatedState) || $this->pipeline->isPipeLineBusy()) {
            return true;
        }
        throw new ModificationNotALlowedException();

    }


    public function getState(): PartialProductSprintState
    {
        return $this->state;
    }

    public function setState(ReleaseSprintState| PartialProductSprintState $state): void
    {
        $this->state = $state;
    }

}
