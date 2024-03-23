<?php

namespace App\Tests;

use App\Domain\Observer\NotificationListener;
use App\Domain\Observer\NotificationManager;
use App\Domain\Users\UserRole;
use PHPUnit\Framework\TestCase;

class NotificationManagerTest extends TestCase
{

    /**
     * @test
     */
    public function it_calls_listener_method()
    {
        $manager = new NotificationManager();
        $listener = $this->createMock( NotificationListener::class);
        $listener->expects($this->once())->method('sendNotification');

        $manager->subscribe(UserRole::TESTER,$listener);
        $manager->notify(UserRole::TESTER,"Test");
    }

    /**
     * @test
     */
    public function it_does_not_call_when_other_role_is_notified()
    {
        $manager = new NotificationManager();
        $listener = $this->createMock( NotificationListener::class);
        $listener->expects($this->never())->method('sendNotification');

        $manager->subscribe(UserRole::TESTER,$listener);
        $manager->notify(UserRole::SCRUM_MASTER,"Test");
    }

    /**
     * @test
     */
    public function it_does_not_call_unsubscribed_listener()
    {
        $manager = new NotificationManager();
        $listener = $this->createMock( NotificationListener::class);
        $listener->expects($this->never())->method('sendNotification');

        $manager->subscribe(UserRole::TESTER,$listener);
        $manager->unsubscribe(UserRole::TESTER,$listener);
        $manager->notify(UserRole::TESTER,"Test");
    }
}
