<?php

namespace App\Domain\Sprint\States\PartialProduct;


use App\Domain\Pipeline\Pipeline;
use App\Domain\SprintReports\SprintReport;

interface PartialProductSprintState
{
    public function progressSprint(): PartialProductSprintState;

    public function cancelSprint(): PartialProductSprintState;

    public function getReport(): ?SprintReport;

    public function setReport(SprintReport $report): void;

}
