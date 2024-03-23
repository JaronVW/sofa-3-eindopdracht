<?php

namespace App\Tests;

use App\Domain\Backlog\BacklogItem\BacklogItem;
use App\Domain\Backlog\EffortPointCount;
use App\Domain\Exceptions\InvalidEffortPointException;
use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Project;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    /**
     * @test
     * @throws InvalidEffortPointException
     * @throws ModificationNotAllowedException
     */
    public function it_moves_backlog_items_from_project_backlog_to_sprint_backlog(): void
    {
        $project = new Project();
        $project->createPartialProductSprint(
            'Partial product release',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-15'),
            new ScrumMaster('Bob')
        );
        $project->addBacklogItem(new BacklogItem(
                'Title',
                'Description',
                new NotificationManager(), null,
                new EffortPointCount(5))
        );

        $this->assertCount(1, $project->getBacklogItems());
        $this->assertCount(0, $project->getSprint("Partial product release")->getBacklogItems());
        $project->moveToSprint($project->getBacklogItems()[0], $project->getSprint("Partial product release"));
        $this->assertCount(0, $project->getBacklogItems());
        $this->assertCount(1, $project->getSprint("Partial product release")->getBacklogItems());
    }
}
