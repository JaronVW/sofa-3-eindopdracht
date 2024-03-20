<?php

namespace App\Entity;

class BacklogActivity
{
    public function __construct(
        private string $description,
        private ?User $developer
    )
    {
    }
}
