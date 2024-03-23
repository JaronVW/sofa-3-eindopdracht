<?php

namespace App\Domain\Users;

use App\Domain\Users\UserRole;

class Developer extends User
{
    private UserRole $role = UserRole::DEVELOPER;

    public function __construct(public readonly string $name)
    {
        parent::__construct();
    }
}
