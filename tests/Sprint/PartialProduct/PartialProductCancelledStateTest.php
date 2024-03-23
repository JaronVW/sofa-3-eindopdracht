<?php

namespace App\Tests\Sprint\PartialProduct;

use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\States\PartialProduct\PartialProductCancelledState;
use App\Domain\SprintReports\SprintReport;
use PHPUnit\Framework\TestCase;

class PartialProductCancelledStateTest extends TestCase
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
        $state = new PartialProductCancelledState();

        self::ExpectException(ModificationNotAllowedException::class);
        $state->progressSprint();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function cancel_throws_exception()
    {
        $state = new PartialProductCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->cancelSprint();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function get_report_throws_exception()
    {
        $state = new PartialProductCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->getReport();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function set_report_throws_exception()
    {
        $state = new PartialProductCancelledState($this->manager);

        self::ExpectException(ModificationNotAllowedException::class);
        $state->setReport($this->createMock(SprintReport::class));
    }


}
