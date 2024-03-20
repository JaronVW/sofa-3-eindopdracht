<?php

namespace App\Entity\Users;

use App\Entity\Observer\UserRole;

class Tester extends User
{
    private UserRole $role = UserRole::TESTER;
    public function __construct()
    {
    }
}
