<?php

namespace App\Tests;

use App\Entity\BacklogItem\BacklogItem;
use App\Entity\BacklogItem\EffortPointCount;
use App\Entity\Exceptions\InvalidEffortPointException;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Observer\NotificationManager;
use App\Entity\Sprint\SprintFactory;
use App\Entity\Sprint\States\Release\ReleaseInProgressState;
use App\Entity\Users\Developer;
use App\Entity\Users\ScrumMaster;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SprintTest extends TestCase
{
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
            new ScrumMaster()
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
            new ScrumMaster()
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
            new ScrumMaster()
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
            new ScrumMaster()
        );

        $sprint->setState(new ReleaseInProgressState());
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
            new ScrumMaster()
        );
        $sprint->setState(new ReleaseInProgressState());
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
            new ScrumMaster()
        );
        $sprint->setState(new ReleaseInProgressState());
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
            new ScrumMaster()
        );
        $backlogitem = new BacklogItem(
            "Refactor variables",
            "Rename variables to make them more descriptive",
            new NotificationManager(),
            new Developer(),
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
            new ScrumMaster()
        );

        $sprint->setState(new ReleaseInProgressState());
        self::expectException(ModificationNotAllowedException::class);

        $sprint->addBacklogItem(
            new BacklogItem(
                "Refactor variables",
                "Rename variables to make them more descriptive",
                new NotificationManager(),
                new Developer(),
                new EffortPointCount(1)
            )
        );
    }
}
