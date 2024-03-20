<?php

namespace App\Entity\Sprint;

use App\Entity\Users\ProductOwner;
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
        ProductOwner      $productOwner
    ): Sprint
    {
        return new ReleaseSprint($name, $startDate, $endDate, $productOwner);
    }

    public static function createPartialProductSPrint(
        string            $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        ProductOwner      $productOwner
    ): Sprint
    {
        return new PartialProductSprint($name, $startDate, $endDate, $productOwner);
    }
}
