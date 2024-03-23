<?php

namespace App\Tests\Sprint\PartialProduct;

use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\PartialProduct\PartialProductCancelledState;
use App\Domain\Sprint\States\PartialProduct\PartialProductFinishedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductInProgressState;
use App\Domain\SprintReports\SprintReport;
use PHPUnit\Framework\TestCase;

class PartialProductInProgressStateTest extends TestCase
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
    public function progress_to_finished_not_allowed_when_report_not_generated()
    {
        $state = new PartialProductInProgressState();

        $state = $state->progressSprint();
        self::assertInstanceOf(PartialProductInProgressState::class, $state);
    }

    /**
     * @test
     */

    public function progress_allowed_when_report_generated()
    {
        $state = new PartialProductInProgressState();

        $state = $state->progressSprint();
        self::assertInstanceOf(PartialProductInProgressState::class, $state);

        $state->setReport($this->createMock(SprintReport::class));
        $state = $state->progressSprint();
        self::assertInstanceOf(PartialProductFinishedState::class, $state);
    }

    /**
     * @test
     */
    public function cancelSprint_moves_to_cancel_state()
    {
        $state = new PartialProductInProgressState();

        $state = $state->cancelSprint();
        self::assertInstanceOf(PartialProductCancelledState::class, $state);
    }

}
