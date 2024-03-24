<?php

namespace App\Domain\Users;

class ScrumMaster extends User
{
    public function __construct(public readonly string $name)
    {
        parent::__construct(UserRole::SCRUM_MASTER);
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }
}
