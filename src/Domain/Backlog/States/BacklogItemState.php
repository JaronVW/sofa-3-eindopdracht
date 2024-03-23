<?php

namespace App\Domain\Backlog\States;

use App\Domain\Exceptions\StateTransitionInvalidException;

interface BacklogItemState
{


    /**
     * @throws StateTransitionInvalidException
     */
    public function progressState(): BacklogItemState;

    /**
     * @throws StateTransitionInvalidException
     */
    public function regressState(): BacklogItemState;
}
