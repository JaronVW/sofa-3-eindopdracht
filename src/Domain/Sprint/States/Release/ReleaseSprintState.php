<?php

namespace App\Domain\Sprint\States\Release;

interface ReleaseSprintState
{
    public function progressSprint();

    public function cancelSprint();

    public function retryPipeline();
}
