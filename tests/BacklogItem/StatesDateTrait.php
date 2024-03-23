<?php

namespace App\Tests\BacklogItem;

use App\Domain\BacklogItem\States\DoingState;
use App\Domain\BacklogItem\States\DoneState;
use App\Domain\BacklogItem\States\ReadyForTestingState;
use App\Domain\BacklogItem\States\TestedState;
use App\Domain\BacklogItem\States\TestingState;
use App\Domain\BacklogItem\States\TodoState;
use App\Domain\Observer\NotificationManager;

trait StatesDateTrait
{
    public function progress_states_data_provider(): iterable
    {
        $manager = new NotificationManager();
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
        $manager = new NotificationManager();
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
