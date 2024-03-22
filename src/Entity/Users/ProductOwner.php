<?php

namespace App\Entity\Users;

use App\Entity\Observer\UserRole;

class ProductOwner extends User
{
    private UserRole $role = UserRole::PRODUCT_OWNER;
    public function __construct(public readonly string $name)
    {
        parent::__construct();
    }

    public function getRole()
    {
        return $this->role;
    }
}
