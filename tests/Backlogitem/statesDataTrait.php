<?php

namespace App\Tests\Backlogitem;

use App\Entity\BacklogItem\Observer\BacklogItemNotificationManager;
use App\Entity\BacklogItem\States\DoingState;
use App\Entity\BacklogItem\States\DoneState;
use App\Entity\BacklogItem\States\ReadyForTestingState;
use App\Entity\BacklogItem\States\TestedState;
use App\Entity\BacklogItem\States\TestingState;
use App\Entity\BacklogItem\States\TodoState;

trait statesDataTrait
{
    public function progress_states_data_provider(): iterable
    {
        $manager = new BacklogItemNotificationManager();
        yield [
            new TodoState($manager),
            new DoingState($manager)
        ];

        yield [
            new DoingState($manager),
            new ReadyForTestingState($manager)
        ];

        yield [
            new ReadyForTestingState($manager),
            new TestingState($manager)
        ];

        yield [
            new TestingState($manager),
            new TestedState($manager)
        ];

        yield [
            new TestedState($manager),
            new DoneState($manager)
        ];

    }

    public function regress_states_data_provider(): iterable
    {
        $manager = new BacklogItemNotificationManager();
        yield [
            new TestedState($manager),
            new TestingState($manager)
        ];

        yield [
            new TestingState($manager),
            new TodoState($manager)
        ];

        yield [
            new ReadyForTestingState($manager),
            new TodoState($manager)
        ];

        yield [
            new DoingState($manager),
            new TodoState($manager)
        ];


        yield [
            new DoneState($manager),
            new ReadyForTestingState($manager)
        ];

    }

}
