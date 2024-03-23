<?php

namespace App\Domain\Users;

use App\Domain\Users\UserRole;

class Tester extends User
{
    private UserRole $role = UserRole::TESTER;
    public function __construct()
    {
    }
}
