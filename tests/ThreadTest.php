<?php

namespace App\Tests;

use App\Entity\BacklogItem\BacklogItem;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Observer\NotificationManager;
use App\Entity\Observer\UserRole;
use App\Entity\Threads\Comment;
use App\Entity\Threads\Thread;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ThreadTest extends TestCase
{

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_allows_editing_topic_name()
    {
        $thread = new Thread(
            "Code cleanup",
            "We need to clean up the code",
            new BacklogItem(
                "Clean up the code",
                "We need to clean up the code",
                new NotificationManager(),
                new User(UserRole::DEVELOPER)
            )
        );
        self::assertSame("Code cleanup", $thread->getTopic());

        $thread->setTopic("Refactoring");
        self::assertSame("Refactoring", $thread->getTopic());
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_allows_editing_content()
    {
        $thread = new Thread(
            "Code cleanup",
            "We need to clean up the code",
            new BacklogItem(
                "Clean up the code",
                "We need to clean up the code",
                new NotificationManager(),
                new User(UserRole::DEVELOPER)
            )
        );
        self::assertSame("We need to clean up the code", $thread->getContent());

        $thread->setContent("We need to refactor the code");
        self::assertSame("We need to refactor the code", $thread->getContent());
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_allows_adding_comments()
    {
        $thread = new Thread(
            "Code cleanup",
            "We need to clean up the code",
            new BacklogItem(
                "Clean up the code",
                "We need to clean up the code",
                new NotificationManager(),
                new User(UserRole::DEVELOPER)
            )
        );
        $thread->addComment(new Comment("I agree", new User(UserRole::DEVELOPER)));
        self::assertSame("I agree", $thread->getComments()[0]->content);
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_disallows_editing_topic_name()
    {
        $backLogItem = new BacklogItem(
            "Clean up the code",
            "We need to clean up the code",
            new NotificationManager(),
            new User(UserRole::DEVELOPER)
        );

        for ($i = 0; $i < 5; $i++) {
            $backLogItem->progressState();
        }

        $thread = new Thread(
            "Code cleanup",
            "We need to clean up the code",
            $backLogItem
        );
        self::expectException(ModificationNotAllowedException::class);
        $thread->setTopic("Refactoring");
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_disallows_editing_content()
    {
        $backLogItem = new BacklogItem(
            "Clean up the code",
            "We need to clean up the code",
            new NotificationManager(),
            new User(UserRole::DEVELOPER)
        );
        $thread = new Thread(
            "Code cleanup",
            "We need to clean up the code",
            $backLogItem
        );

        for ($i = 0; $i < 5; $i++) {
            $backLogItem->progressState();
        }

        self::expectException(ModificationNotAllowedException::class);
        $thread->setContent("We need to refactor the code");
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     */
    public function it_disallows_adding_comments()
    {
        $backLogItem = new BacklogItem(
            "Clean up the code",
            "We need to clean up the code",
            new NotificationManager(),
            new User(UserRole::DEVELOPER)
        );
        $thread = new Thread(
            "Code cleanup",
            "We need to clean up the code",
            $backLogItem
        );

        for ($i = 0; $i < 5; $i++) {
            $backLogItem->progressState();
        }

        self::expectException(ModificationNotAllowedException::class);
        $thread->addComment(new Comment("I agree", new User(UserRole::DEVELOPER)));
    }
}
