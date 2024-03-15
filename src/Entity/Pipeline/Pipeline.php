<?php

namespace App\Entity\Pipeline;

class Pipeline implements DevopsAction
{
    /**
     * @param array<int,DevopsAction> $actions
     */
    public function __construct(
        private array $actions
    )
    {
    }
}
