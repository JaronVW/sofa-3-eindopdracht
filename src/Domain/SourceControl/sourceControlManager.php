<?php

namespace App\Domain\SourceControl;

use App\Domain\Backlog\BacklogActivity;
use App\Domain\Backlog\BacklogItem\BacklogItem;
use App\Domain\Libraries\SourceControl\SourceControlLibrary;
use App\Domain\Sprint\Sprint;

class sourceControlManager
{

    public function __construct(private SourceControlLibrary $sourceControl)
    {
    }

    public function linkSprintToIssue(Sprint $sprint, string $url): void
    {
       $this->sourceControl->linkIssue(sprintf('Sprint %s with %s linked', $sprint->getName(), $url));
    }

    public function linkBackLogItemToIssue(BacklogItem $backlogItem, string $url): void
    {
        $this->sourceControl->linkIssue(sprintf('Backlog item%s with %s linked', $backlogItem->title, $url));
    }

    public function linkBacklogActivityIssue(BacklogActivity $backlogActivity, string $url): void
    {
        $this->sourceControl->linkIssue(sprintf('Backlog activity %s with %s linked', $backlogActivity->title, $url));
    }

}
