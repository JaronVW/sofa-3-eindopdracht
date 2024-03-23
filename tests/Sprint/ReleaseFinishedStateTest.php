<?php

namespace App\Tests\Sprint;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\Release\ReleaseCancelledState;
use App\Domain\Sprint\States\Release\ReleaseFinishedState;
use App\Domain\Sprint\States\Release\ReleaseInProgressState;
use PHPUnit\Framework\TestCase;

class ReleaseFinishedStateTest extends TestCase
{
    private NotificationManager $manager;
    private Pipeline $pipeline;

    protected function setUp(): void
    {
        $this->manager = new NotificationManager();
        $this->pipeline = new Pipeline();
    }

    /**
     * @test
     */
    public function ProgressSprint_throws_exception()
    {
        $state = new ReleaseFinishedState($this->manager);

        self::expectException(ModificationNotAllowedException::class);
        $state->progressSprint($this->manager, $this->pipeline);
    }

    /**
     * @test
     */
    public function CancelSprint_throws_exception()
    {
        $state = new ReleaseFinishedState($this->manager);

        self::expectException(ModificationNotAllowedException::class);
        $state->cancelSprint();
    }

    /**
     * @test
     */
    public function RetryPipeline_throws_exception()
    {
        $state = new ReleaseFinishedState($this->manager);

        self::expectException(ModificationNotAllowedException::class);
        $state->retryPipeline();
    }

    /**
     * @test
     */
    public function GetPipeline_throws_exception()
    {
        $state = new ReleaseFinishedState($this->manager);

        self::expectException(ModificationNotAllowedException::class);
        $state->getPipeline();
    }

    /**
     * @test
     */
    public function SetPipeline_throws_exception()
    {
        $state = new ReleaseFinishedState($this->manager);

        self::expectException(ModificationNotAllowedException::class);
        $state->setPipeline($this->pipeline);
    }

}
