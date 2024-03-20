<?php

namespace App\Entity\Sprint;

use App\Entity\Users\ProductOwner;
use App\Entity\Users\ScrumMaster;
use DateTimeImmutable;

class SprintFactory
{
    public function __construct()
    {
    }

    public static function createReleaseSprint(
        string            $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        ScrumMaster       $scrumMaster,
        ProductOwner      $productOwner = null
    ): Sprint
    {
        return new ReleaseSprint($name, $startDate, $endDate, $scrumMaster, $productOwner);
    }

    public static function createPartialProductSPrint(
        string            $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        ScrumMaster       $scrumMaster,
        ProductOwner      $productOwner = null
    ): Sprint
    {
        return new PartialProductSprint($name, $startDate, $endDate, $scrumMaster, $productOwner);
    }
}
