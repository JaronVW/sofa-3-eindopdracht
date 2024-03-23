<?php

namespace App\Domain\Sprint\States\PartialProduct;

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

}
