<?php

namespace App\Entity\BacklogItem\Thread;

class Thread
{
    /**
     * @param array<int,Comment> $comments
     */
    public function __construct(
         private array $comments
     )
     {
     }
}
