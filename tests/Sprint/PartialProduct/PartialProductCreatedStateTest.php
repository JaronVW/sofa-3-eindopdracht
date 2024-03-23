<?php

namespace App\Tests\Sprint\PartialProduct;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\PartialProduct\PartialProductCancelledState;
use App\Domain\Sprint\States\PartialProduct\PartialProductCreatedState;
use App\Domain\Sprint\States\PartialProduct\PartialProductInProgressState;
use App\Domain\SprintReports\SprintReport;
use PHPUnit\Framework\TestCase;

class PartialProductCreatedStateTest extends TestCase
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
    public function progress_sprint_moves_to_in_progress()
    {
        $state = new PartialProductCreatedState();

        $state = $state->progressSprint();
        self::assertInstanceOf(PartialProductInProgressState::class, $state);
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function cancelSprint_moves_to_cancelled()
    {
        $state = new PartialProductCreatedState();
        $state = $state->cancelSprint();

        self::assertInstanceOf(PartialProductCancelledState::class, $state);
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function get_report_throws_exception()
    {
        $state = new PartialProductCreatedState();

        self::expectException(ModificationNotAllowedException::class);
        $state->getReport();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function setReport_throws_exception()
    {
        $state = new PartialProductCreatedState();

        self::expectException(ModificationNotAllowedException::class);
        $state->setReport($this->createMock(SprintReport::class));
    }


}
