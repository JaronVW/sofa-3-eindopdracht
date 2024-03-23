<?php

namespace App\Domain\Sprint\States\Release;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;


interface ReleaseSprintState 
{
    public function progressSprint(NotificationManager $manager, Pipeline $pipeline): ReleaseSprintState;

    public function cancelSprint();

    public function retryPipeline();


    public function getPipeline(): Pipeline;

    public function setPipeline(Pipeline $pipeline): void;
}
