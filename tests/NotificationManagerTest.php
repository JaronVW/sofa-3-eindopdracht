<?php

namespace App\Tests;

use App\Entity\Libraries\SlackLibrary;
use App\Entity\Observer\NotificationManager;
use App\Entity\Observer\SlackListenerAdapter;
use App\Entity\Observer\UserRole;
use PHPUnit\Framework\TestCase;

class NotificationManagerTest extends TestCase
{

    /**
     * @test
     */
    public function it_calls_listener_method()
    {
        $manager = new NotificationManager();
        $mockLibrary = $this->createMock(SlackLibrary::class);
        $mockLibrary->expects($this->once())->method('sendSlack');

        $listener = new SlackListenerAdapter($mockLibrary,"test","topic");
        $manager->subscribe(UserRole::TESTER,$listener);
        $manager->notify(UserRole::TESTER,"Test");
    }

    /**
     * @test
     */
    public function it_does_not_call_when_other_role_is_notified()
    {
        $manager = new NotificationManager();
        $mockLibrary = $this->createMock(SlackLibrary::class);
        $mockLibrary->expects($this->never())->method('sendSlack');

        $listener = new SlackListenerAdapter($mockLibrary,"test","topic");
        $manager->subscribe(UserRole::TESTER,$listener);
        $manager->notify(UserRole::SCRUM_MASTER,"Test");
    }

    /**
     * @test
     */
    public function it_does_not_call_unsubscribed_listener()
    {
        $manager = new NotificationManager();
        $mockLibrary = $this->createMock(SlackLibrary::class);
        $mockLibrary->expects($this->never())->method('sendSlack');

        $listener = new SlackListenerAdapter($mockLibrary,"test","topic");
        $manager->subscribe(UserRole::TESTER,$listener);
        $manager->unsubscribe(UserRole::TESTER,$listener);
        $manager->notify(UserRole::TESTER,"Test");
    }
}
