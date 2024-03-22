<?php

namespace App\Tests;

use App\Entity\BacklogItem\BacklogItem;
use App\Entity\BacklogItem\EffortPointCount;
use App\Entity\Exceptions\InvalidEffortPointException;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Exceptions\StateTransitionInvalidException;
use App\Entity\Observer\NotificationManager;
use App\Entity\Threads\Comment;
use App\Entity\Threads\Thread;
use App\Entity\Users\Developer;
use PHPUnit\Framework\TestCase;

class ThreadTest extends TestCase
{

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException
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
                new Developer("Alice"),
                new EffortPointCount(1)
            )
        );
        self::assertSame("Code cleanup", $thread->getTopic());

        $thread->setTopic("Refactoring");
        self::assertSame("Refactoring", $thread->getTopic());
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException
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
                new Developer("Alice"),
                new EffortPointCount(1)
            )
        );
        self::assertSame("We need to clean up the code", $thread->getContent());

        $thread->setContent("We need to refactor the code");
        self::assertSame("We need to refactor the code", $thread->getContent());
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException
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
                new Developer("Alice"),
                new EffortPointCount(1)
            )
        );
        $thread->addComment(new Comment("I agree", new Developer("Alice")));
        self::assertSame("I agree", $thread->getComments()[0]->content);
    }

    /**
     * @test
     * @throws ModificationNotAllowedException
     * @throws InvalidEffortPointException|StateTransitionInvalidException
     */
    public function it_disallows_editing_topic_name()
    {
        $backLogItem = new BacklogItem(
            "Clean up the code",
            "We need to clean up the code",
            new NotificationManager(),
            new Developer("Alice"),
            new EffortPointCount(1)
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
     * @throws InvalidEffortPointException
     */
    public function it_disallows_editing_content()
    {
        $backLogItem = new BacklogItem(
            "Clean up the code",
            "We need to clean up the code",
            new NotificationManager(),
            new Developer("Alice"),
            new EffortPointCount(1)
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
     * @throws InvalidEffortPointException
     */
    public function it_disallows_adding_comments()
    {
        $backLogItem = new BacklogItem(
            "Clean up the code",
            "We need to clean up the code",
            new NotificationManager(),
            new Developer("Alice"),
            new EffortPointCount(1)

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
        $thread->addComment(new Comment("I agree", new Developer("Alice")));
    }
}
