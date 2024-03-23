<?php

namespace App\Domain\Sprint;

use App\Domain\Users\ProductOwner;
use App\Domain\Users\ScrumMaster;
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
