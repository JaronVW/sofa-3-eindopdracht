<?php

namespace App\Tests\Backlogitem;

use App\Entity\BacklogActivity;
use App\Entity\BacklogItem\BacklogItem;
use App\Entity\BacklogItem\States\TodoState;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Exceptions\StateTransitionInvalidException;
use App\Entity\Observer\NotificationManager;
use App\Entity\Threads\Thread;
use PHPUnit\Framework\TestCase;

class BacklogItemTest extends TestCase
{

    /**
     * @test
     * @throws StateTransitionInvalidException
     * @throws ModificationNotAllowedException
     */
    public function it_disallows_changing_to_done_when_comments_are_not_done()
    {
        $backlogItem = new BacklogItem('Create subtask menu', 'The user interface could use a subtask menu', new NotificationManager(), null);
        $backlogItem->addBacklogActivity(new BacklogActivity('Style menu with css', null));
        self::expectException(ModificationNotAllowedException::class);
        $backlogItem->setDone();
    }

    /**
     * @test
     * @throws StateTransitionInvalidException
     * @throws ModificationNotAllowedException
     */
    public function it_allows_changing_to_done_when_comments_are_done(): void
    {
        $backlogItem = new BacklogItem('Create subtask menu', 'The user interface could use a subtask menu', new NotificationManager(), null);
        $backlogItem->addBacklogActivity(new BacklogActivity('Style menu with css', null));
        $backlogItem->getBacklogActivities()[0]->setDone();
        $backlogItem->setDone();
        self::assertTrue($backlogItem->isDone());
    }
}
