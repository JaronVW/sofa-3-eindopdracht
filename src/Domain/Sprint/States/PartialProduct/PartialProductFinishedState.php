<?php

namespace App\Domain\Sprint\States\PartialProduct;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Sprint\PartialProductSprint;
use App\Domain\Sprint\States\Release\ReleaseSprintState;

class PartialProductFinishedState implements PartialProductSprintState
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
}
