<?php

namespace App\Entity\Users;

use App\Entity\Observer\UserRole;

class Developer extends User
{
    private UserRole $role = UserRole::DEVELOPER;

    public function __construct(public readonly string $name)
    {
        parent::__construct();
    }
}
