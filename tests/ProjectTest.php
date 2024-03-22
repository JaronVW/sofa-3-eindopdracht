<?php

namespace App\Tests;

use App\Entity\Backlog;
use App\Entity\BacklogItem\BacklogItem;
use App\Entity\BacklogItem\EffortPointCount;
use App\Entity\Exceptions\InvalidEffortPointException;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Observer\NotificationManager;
use App\Entity\Project;
use App\Entity\Sprint\SprintFactory;
use App\Entity\Users\ScrumMaster;
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
