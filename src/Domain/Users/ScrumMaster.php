<?php

namespace App\Domain\Users;

class ScrumMaster extends User
{
    private UserRole $role = UserRole::SCRUM_MASTER;
    public function __construct(public readonly string $name)
    {
        parent::__construct();
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }
}
