<?php
declare(strict_types=1);

namespace App\Tests\Backlogitem;

use App\Entity\BacklogItem\States\BacklogItemState;
use App\Entity\BacklogItem\States\DoneState;
use App\Entity\BacklogItem\States\TestedState;
use App\Entity\BacklogItem\States\TodoState;
use App\Entity\Exceptions\StateTransitionInvalidException;
use App\Entity\Observer\NotificationManager;
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
