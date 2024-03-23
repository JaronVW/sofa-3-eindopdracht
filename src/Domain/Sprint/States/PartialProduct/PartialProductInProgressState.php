<?php

namespace App\Domain\Sprint\States\PartialProduct;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Sprint\PartialProductSprint;
use App\Domain\SprintReports\SprintReport;
use App\Domain\Users\User;

class PartialProductInProgressState implements PartialProductSprintState
{
    private ?SprintReport $report;

    public function __construct()
    {
        $this->report = null;
    }

    public function progressSprint(): PartialProductSprintState
    {
        if ($this->report !== null) {
            return new PartialProductFinishedState();
        }
        echo "Sprint report not handed in\n";
        return $this;
    }

    public function cancelSprint(): PartialProductSprintState
    {
        return new PartialProductCancelledState();
    }

    public function getReport(): ?SprintReport
    {
        return $this->report;
    }

    public function setReport(SprintReport $report): void
    {
        $this->report = $report;
    }
}
