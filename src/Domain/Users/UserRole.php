<?php

namespace App\Domain\Users;

enum UserRole: string
{
    case TESTER = "Tester";
    case SCRUM_MASTER = "Scrum master";

    case DEVELOPER = "Developer";

    case PRODUCT_OWNER = "Product owner";
}
