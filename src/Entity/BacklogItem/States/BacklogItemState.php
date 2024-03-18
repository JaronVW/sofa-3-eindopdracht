<?php

namespace App\Entity\BacklogItem\States;

use App\Entity\Exceptions\StateTransitionInvalidException;

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
