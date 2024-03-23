<?php

namespace App\Domain\Sprint;

use App\Domain\Sprint\States\PartialProduct\PartialProductCancelledState;
use App\Domain\Sprint\States\PartialProduct\PartialProductCreatedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductFinishedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductSprintState;
use App\Domain\Sprint\States\Release\ReleaseSprintState;
use App\Domain\Users\ProductOwner;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;

class PartialProductSprint extends Sprint
{

    public function __construct(string $name, DateTimeImmutable $startDate, DateTimeImmutable $endDate, ScrumMaster $scrumMaster, ?ProductOwner $productOwner = null)
    {
        parent::__construct($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->state = new PartialProductCreatedState();
    }

    public function progressSprint(): void
    {
        $this->state = new PartialProductFinishedState();
    }

    public function cancelSprint(): void
    {
        $this->state = new PartialProductCancelledState();
    }
}
