<?php

namespace App\Entity;

class BacklogActivity
{
    private bool $done = false;
    public function __construct(
        private string $description,
        private ?User $developer,
    )
    {
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function setDone(): void
    {
        $this->done = true;
    }
}
