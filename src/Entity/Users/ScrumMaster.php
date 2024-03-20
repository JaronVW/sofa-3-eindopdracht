<?php

namespace App\Entity\Users;

use App\Entity\Observer\UserRole;

class ScrumMaster extends User
{
    private UserRole $role = UserRole::SCRUM_MASTER;
    public function __construct()
    {
    }
}
