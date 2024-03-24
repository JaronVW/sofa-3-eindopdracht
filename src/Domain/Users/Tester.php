<?php

namespace App\Domain\Users;


class Tester extends User
{
    public function __construct()
    {
        parent::__construct(UserRole::TESTER);
    }
}
