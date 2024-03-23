<?php

namespace App\Tests\SourceControl;

use App\Domain\Backlog\BacklogActivity;
use App\Domain\Backlog\BacklogItem\BacklogItem;
use App\Domain\Backlog\EffortPointCount;
use App\Domain\Exceptions\InvalidEffortPointException;
use App\Domain\Libraries\SourceControl\GitLibraryAdapter;
use App\Domain\Observer\NotificationManager;
use App\Domain\SourceControl\sourceControlManager;
use App\Domain\Sprint\SprintFactory;
use App\Domain\Users\Developer;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SourceControlLibraryLibraryTest extends TestCase
{
    /**
     * @test
     */
    public function it_links_sprints_to_issues()
    {
        $library = $this->createMock(GitLibraryAdapter::class);
        $library->expects($this->once())->method('linkIssue')->willReturn("Sprint 1 with issue fs0-32919 linked");
        $scm = new sourceControlManager($library);
        $sprint = SprintFactory::createReleaseSprint(
            "Sprint 1",
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ScrumMaster("John Doe"),
        );

        $scm->linkSprintToIssue($sprint, "example.com/fs0-32919");
    }

    /**
     * @test
     * @throws InvalidEffortPointException
     */
    public function it_links_backlog_items_to_issues()
    {
        $library = $this->createMock(GitLibraryAdapter::class);
        $library->expects($this->once())->method('linkIssue')->willReturn("Backlog item Backlog Item 1 with issue fs0-32919 linked");
        $scm = new sourceControlManager($library);
        $backlogItem = new BacklogItem(
            "Backlog Item 1",
            "Description",
            $this->createMock(NotificationManager::class),
            new Developer("John Doe"),
            new EffortPointCount(1)
        );

        $scm->linkBackLogItemToIssue($backlogItem, "example.com/fs0-32919");
    }

    /**
     * @test
     */
    public function it_links_backlog_activities_to_issues()
    {
        $library = $this->createMock(GitLibraryAdapter::class);
        $library->expects($this->once())->method('linkIssue')->willReturn("Backlog activity Backlog Activity 1 with issue fs0-32919 linked");

        $scm = new sourceControlManager($library);
        $backlogActivity = new BacklogActivity(
            "Backlog Activity 1",
            "Description",
            new Developer("John Doe"),
        );
        $scm->linkBacklogActivityIssue($backlogActivity, "example.com/fs0-32919");
    }
}
