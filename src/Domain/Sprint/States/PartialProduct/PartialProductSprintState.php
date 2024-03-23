<?php

namespace App\Domain\Sprint\States\PartialProduct;


interface PartialProductSprintState
{
    public function progressSprint(): PartialProductSprintState;

    public function cancelSprint(): PartialProductSprintState;

}
