<?php
declare(strict_types=1);

namespace App\Tests\BacklogItem;

use App\Domain\Backlog\States\BacklogItemState;
use App\Domain\Backlog\States\DoneState;
use App\Domain\Backlog\States\TestedState;
use App\Domain\Backlog\States\TodoState;
use App\Domain\Exceptions\StateTransitionInvalidException;
use App\Domain\Observer\NotificationManager;
use PHPUnit\Framework\TestCase;

class BacklogItemStateTest extends TestCase
{
    use StatesDateTrait;

    /**
     * @test
     * @dataProvider progress_states_data_provider
     */
    public function it_handles_progressing_states_correctly(BacklogItemState $initialState, BacklogItemState $expectedState)
    {
        self::assertEquals($initialState->progressState(), $expectedState);
    }

    /**
     * @test
     * @dataProvider regress_states_data_provider
     */
    public function it_handles_regressing_states_correctly(BacklogItemState $initialState, BacklogItemState $expectedState)
    {
        self::assertEquals($initialState->regressState(), $expectedState);
    }

    /**
     * @test
     */
    public function it_throws_exception_when_todo_regress()
    {
        self::expectException(StateTransitionInvalidException::class);

        $manager = new NotificationManager();
        $state = new TodoState($manager);
        $state->regressState();
    }

    /**
     * @test
     */
    public function it_throws_exception_when_doing_progress()
    {
        self::expectException(StateTransitionInvalidException::class);

        $manager = new NotificationManager();
        $state = new DoneState($manager);
        $state->progressState();
    }


    /**
     * @test
     */
    public function it_handles_reset_state_correctly()
    {
        $manager = new NotificationManager();
        $state = new TestedState($manager);
        self::assertEquals($state->resetState(), new TodoState($manager));
    }



}
