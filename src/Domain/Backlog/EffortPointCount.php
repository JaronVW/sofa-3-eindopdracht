<?php

namespace App\Domain\Backlog;

use App\Domain\Exceptions\InvalidEffortPointException;

class EffortPointCount
{
    private array $validEffortPoints = [1, 2, 3, 5, 8, 13, 20, 40, 100];

    public function __construct(int $points)
    {
        if (!in_array($points, $this->validEffortPoints)){
           throw new InvalidEffortPointException();
        }
    }
}
