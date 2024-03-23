<?php

namespace App\Domain\Sprint\States\PartialProduct;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Pipeline\Pipeline;
use App\Domain\SprintReports\SprintReport;

class PartialProductCreatedState implements PartialProductSprintState
{

    public function __construct()
    {
    }

    public function progressSprint(): PartialProductSprintState
    {
        return new PartialProductInProgressState();
    }

    public function cancelSprint(): PartialProductSprintState
    {
        return new PartialProductCancelledState();
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function getReport(): ?SprintReport
    {
       throw new ModificationNotAllowedException();
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setReport(SprintReport $report): void
    {
        throw new ModificationNotAllowedException();
    }
}
