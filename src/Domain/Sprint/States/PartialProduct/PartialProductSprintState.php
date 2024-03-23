<?php

namespace App\Domain\Sprint\States\PartialProduct;


use App\Domain\Pipeline\Pipeline;

interface PartialProductSprintState
{
    public function progressSprint(): PartialProductSprintState;

    public function cancelSprint(): PartialProductSprintState;

    public function getPipeline(): Pipeline;

}
