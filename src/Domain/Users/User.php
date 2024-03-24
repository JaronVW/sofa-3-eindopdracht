<?php

namespace App\Domain\Users;


abstract class User
{
    public function __construct(
      protected UserRole $role
    )
    {
    }
}
