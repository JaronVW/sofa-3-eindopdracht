<?php

namespace App\Domain\Threads;

use App\Domain\Users\User;

class Comment
{
    public function __construct(
        public readonly string $content,
        public readonly User $user
    )
    {
    }
}
