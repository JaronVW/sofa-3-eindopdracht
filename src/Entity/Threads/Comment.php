<?php

namespace App\Entity\Threads;

use App\Entity\Users\User;

class Comment
{
    public function __construct(
        public readonly string $content,
        public readonly User $user
    )
    {
    }
}
