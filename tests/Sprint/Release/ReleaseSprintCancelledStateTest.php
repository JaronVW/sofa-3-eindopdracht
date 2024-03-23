<?php

namespace App\Tests\Sprint\Release;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\Release\ReleaseCancelledState;
use PHPUnit\Framework\TestCase;

class ReleaseSprintCancelledStateTest extends TestCase
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
    public function progress_throws_exception()
    {
        $state = new ReleaseCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->progressSprint($this->manager, $this->pipeline);
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function cancel_throws_exception()
    {
        $state = new ReleaseCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->cancelSprint();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function retry_throws_exception()
    {
        $state = new ReleaseCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->retryPipeline();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function getPipeline_throws_exception()
    {
        $state = new ReleaseCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->getPipeline();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function setPipeline_throws_exception()
    {
        $state = new ReleaseCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->setPipeline($this->pipeline);
    }


}
