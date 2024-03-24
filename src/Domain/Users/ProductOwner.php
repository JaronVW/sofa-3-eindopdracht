<?php

namespace App\Domain\Users;


class ProductOwner extends User
{
    public function __construct(public readonly string $name)
    {
        parent::__construct(UserRole::PRODUCT_OWNER);
    }

    public function getRole()
    {
        return $this->role;
    }
}
