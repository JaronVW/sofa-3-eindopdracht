<?php

namespace App\Tests;

use App\Domain\Backlog\BacklogItem\BacklogItem;
use App\Domain\Backlog\EffortPointCount;
use App\Domain\Exceptions\InvalidEffortPointException;
use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\PipelineFailedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Pipeline\Pipeline;
use App\Domain\Sprint\SprintFactory;
use App\Domain\Sprint\States\Release\ReleaseFinishedState;
use App\Domain\Sprint\States\Release\ReleaseInProgressState;
use App\Domain\Users\Developer;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class SprintTest extends TestCase
{
    use ProphecyTrait;

    /** @var ObjectProphecy<Pipeline> */
    private ObjectProphecy $pipeline;

    private NotificationManager $manager;

    protected function setUp(): void
    {
        $this->manager = new NotificationManager();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_allows_editing_sprint_name()
    {
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ScrumMaster("Bob")
        );
        self::assertSame("Code cleanup", $sprint->getName());

        $sprint->setName("Refactoring");
        self::assertSame("Refactoring", $sprint->getName());
    }


    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_allows_editing_sprint_start_date()
    {
        $start = new DateTimeImmutable("2024-03-7");
        $newStart = new DateTimeImmutable("2024-05-3");
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            $start,
            new DateTimeImmutable(),
            new ScrumMaster("Bob")
        );
        self::assertSame($start, $sprint->getStartDate());

        $sprint->setStartDate($newStart);
        self::assertSame($newStart, $sprint->getStartDate());
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_allows_editing_sprint_end_date()
    {
        $end = new DateTimeImmutable("2024-03-7");
        $newEnd = new DateTimeImmutable("2024-05-3");
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            new DateTimeImmutable(),
            $end,
            new ScrumMaster("Bob")
        );
        self::assertSame($end, $sprint->getEndDate());

        $sprint->setEndDate($newEnd);
        self::assertSame($newEnd, $sprint->getEndDate());
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_disallows_editing_sprint_name()
    {
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ScrumMaster("Bob")
        );

        $sprint->setState(new ReleaseInProgressState($this->manager, $this->createMock(Pipeline::class)));
        self::expectException(ModificationNotAllowedException::class);
        $sprint->setName("Refactoring");
    }


    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_disallows_editing_sprint_start_date()
    {
        $start = new DateTimeImmutable("2024-03-7");
        $newStart = new DateTimeImmutable("2024-05-3");
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            $start,
            new DateTimeImmutable(),
            new ScrumMaster("Bob")
        );
        $sprint->setState(new ReleaseInProgressState($this->manager, $this->createMock(Pipeline::class)));
        self::expectException(ModificationNotAllowedException::class);
        $sprint->setStartDate($newStart);
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_disallows_editing_sprint_end_date()
    {
        $end = new DateTimeImmutable("2024-03-7");
        $newEnd = new DateTimeImmutable("2024-05-3");
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            new DateTimeImmutable(),
            $end,
            new ScrumMaster("Bob")
        );
        $sprint->setState(new ReleaseInProgressState($this->manager, $this->createMock(Pipeline::class)));
        self::expectException(ModificationNotAllowedException::class);
        $sprint->setEndDate($newEnd);
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException
     */
    public function it_allows_adding_backlog_items()
    {
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ScrumMaster("Bob")
        );
        $backlogitem = new BacklogItem(
            "Refactor variables",
            "Rename variables to make them more descriptive",
            new NotificationManager(),
            new Developer("Alice"),
            new EffortPointCount(1)
        );
        self::assertEquals([], $sprint->getBacklogItems());
        $sprint->addBacklogItem(
            $backlogitem
        );
        self::assertEquals([$backlogitem], $sprint->getBacklogItems());
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException
     */
    public function it_disallows_adding_backlog_items()
    {
        $sprint = SprintFactory::createReleaseSprint(
            "Code cleanup",
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ScrumMaster("Bob")
        );

        $sprint->setState(new ReleaseInProgressState($this->manager, $this->createMock(Pipeline::class)));
        self::expectException(ModificationNotAllowedException::class);

        $sprint->addBacklogItem(
            new BacklogItem(
                "Refactor variables",
                "Rename variables to make them more descriptive",
                new NotificationManager(),
                new Developer("Alice"),
                new EffortPointCount(1)
            )
        );
    }

    /**
     * @test
     */
    public function it_finishes_release_sprint_correctly(): void
    {
        $sprint = SprintFactory::createReleaseSprint(
            "Release new Authentication service",
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ScrumMaster("John")
        );

        $sprint->setState(new ReleaseInProgressState($this->manager, $this->createMock(Pipeline::class)));
        $sprint->progressSprint();
        self::assertInstanceOf(ReleaseFinishedState::class, $sprint->getState());

    }

    /**
     * @test
     * @throws PipelineFailedException
     */
    public function it_fails_when_pipeline_fails_and_correctly_finishes_when_pipeline_retries_successfully()
    {

        $sprint = SprintFactory::createReleaseSprint(
            "Release new Authentication service",
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ScrumMaster("John")
        );

        $this->pipeline = $this->prophesize(Pipeline::class);
        $sprint->setPipeline($this->pipeline->reveal());

        $this->pipeline->execute()->willThrow(PipelineFailedException::class);

        $sprint->progressSprint();
        $sprint->progressSprint();
        self::assertInstanceOf(ReleaseInProgressState::class, $sprint->getState());

        $this->pipeline->didPipeLineFail()->willReturn(true);
        $this->pipeline->execute()->will(function (){});

        $sprint->retryPipeline();
        self::assertInstanceOf(ReleaseFinishedState::class, $sprint->getState());

    }
}
