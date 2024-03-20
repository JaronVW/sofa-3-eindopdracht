<?php

namespace App\Tests\BacklogItem;

use App\Entity\BacklogActivity;
use App\Entity\BacklogItem\BacklogItem;
use App\Entity\BacklogItem\EffortPointCount;
use App\Entity\Exceptions\InvalidEffortPointException;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Observer\NotificationManager;
use PHPUnit\Framework\TestCase;

class BacklogItemTest extends TestCase
{

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException
     */
    public function it_disallows_changing_to_done_when_backlog_items_are_not_done()
    {
        $backlogItem = new BacklogItem(
            'Create subtask menu',
            'The user interface could use a subtask menu',
            new NotificationManager(),
            null,
            new EffortPointCount(1)
        );
        $backlogItem->addBacklogActivity(new BacklogActivity('Style menu with css', null));
        self::expectException(ModificationNotAllowedException::class);
        $backlogItem->setDone();
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException
     */
    public function it_allows_changing_to_done_when_backlog_activities_are_done(): void
    {
        $backlogItem = new BacklogItem(
            'Create subtask menu',
            'The user interface could use a subtask menu',
            new NotificationManager(),
            null,
            new EffortPointCount(1)
        );
        $backlogItem->addBacklogActivity(new BacklogActivity('Style menu with css', null));
        $backlogItem->getBacklogActivities()[0]->setDone();
        $backlogItem->setDone();
        self::assertTrue($backlogItem->isDone());
    }

}
