<?php

namespace App\Entity\BacklogItem\Observer;

enum UserRole: string
{
    case TESTER = "Tester";
    case SCRUM_MASTER = "Scrum master";

    case DEVELOPER = "Developer";
}
