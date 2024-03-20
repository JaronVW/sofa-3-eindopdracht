<?php

namespace App\Entity\Observer;

enum UserRole: string
{
    case TESTER = "Tester";
    case SCRUM_MASTER = "Scrum master";

    case DEVELOPER = "Developer";
}
