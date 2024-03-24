<?php

namespace App\Domain\Users;

class Developer extends User
{

    public function __construct(public readonly string $name)
    {
        parent::__construct(UserRole::DEVELOPER);
    }
}
