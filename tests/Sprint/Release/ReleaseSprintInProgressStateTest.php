<?php

namespace App\Tests\Sprint\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineRestartNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\Release\ReleaseCancelledState;
use App\Domain\Sprint\States\Release\ReleaseFinishedState;
use App\Domain\Sprint\States\Release\ReleaseInProgressState;
use PHPUnit\Framework\TestCase;

class ReleaseSprintInProgressStateTest extends TestCase
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
    public function progressSprint_moves_to_finished_state()
    {
        $state = new ReleaseInProgressState($this->manager, $this->pipeline);

        $state = $state->progressSprint($this->manager, $this->pipeline);
        self::assertInstanceOf(ReleaseFinishedState::class, $state);

    }

    /**
     * @test
     */
    public function cancelSprint_moves_to_cancel_state()
    {
        $state = new ReleaseInProgressState($this->manager, $this->pipeline);

        $state = $state->cancelSprint();
        self::assertInstanceOf(ReleaseCancelledState::class, $state);
    }

    /**
     * @test
     * @throws PipelineRestartNotAllowedException
     */
    public function retryPipeline_throws_exception()
    {
        $state = new ReleaseInProgressState($this->manager, $this->pipeline);

        self::expectException(PipelineRestartNotAllowedException::class);
        $state->retryPipeline();
    }

    /**
     * @test
     */
    public function setPipeline_throws_exception()
    {
        $state = new ReleaseInProgressState($this->manager, $this->pipeline);

        self::expectException(ModificationNotAllowedException::class);
        $state->setPipeline($this->pipeline);
    }


}
