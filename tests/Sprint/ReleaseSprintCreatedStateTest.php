<?php

namespace App\Tests\Sprint;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\Release\ReleaseCancelledState;
use App\Domain\Sprint\States\Release\ReleaseCreatedState;
use App\Domain\Sprint\States\Release\ReleaseInProgressState;
use PHPUnit\Framework\TestCase;

class ReleaseSprintCreatedStateTest extends TestCase
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
     * @throws ModificationNotAllowedException
     */
    public function progressSprint_moves_to_in_progress_state()
    {
        $state = new ReleaseCreatedState($this->manager, $this->pipeline);

        $state = $state->progressSprint($this->manager, $this->pipeline);
        self::assertInstanceOf(ReleaseInProgressState::class, $state);

    }

    /**
     * @test
     */
    public function cancelSprint_moves_to_cancel_state()
    {
        $state = new ReleaseCreatedState($this->manager, $this->pipeline);

        $state = $state->cancelSprint();
        self::assertInstanceOf(ReleaseCancelledState::class, $state);
    }

    /**
     * @test
     */
    public function retryPipeline_throws_exception()
    {
        $state = new ReleaseCreatedState($this->manager, $this->pipeline);

        self::expectException(PipelineRestartNotAllowedException::class);
        $state->retryPipeline();
    }

    /**
     * @test
     */
    public function getPipeline_throws_exception()
    {
        $state = new ReleaseCreatedState($this->manager, $this->pipeline);

        self::expectException(ModificationNotAllowedException::class);
        $state->getPipeline();
    }

}
