<?php

namespace App\Entity\Sprint\States;

interface SprintState
{
    public function finishSprint();

    public function cancelSprint();

    public function retryPipeline();
}
