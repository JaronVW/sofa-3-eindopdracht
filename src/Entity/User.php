<?php

namespace App\Entity;

use App\Entity\BacklogItem\Observer\UserRole;

final readonly class User
{
    public function __construct(

       public UserRole $role
    )
    {
    }
}
