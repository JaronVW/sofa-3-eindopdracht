<?php

namespace App\Domain\Sprint\States\PartialProduct;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Pipeline\Pipeline;

class PartialProductCancelledState implements PartialProductSprintState
{

    public function __construct()
    {
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function progressSprint(): PartialProductSprintState
    {
        throw new ModificationNotAllowedException();
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function cancelSprint(): PartialProductSprintState
    {
        throw new ModificationNotAllowedException();
    }

    public function getPipeline(): Pipeline
    {
        throw new ModificationNotAllowedException();
    }
}
