<?php

namespace App\Entity\Sprint;

use DateTimeImmutable;

class SprintFactory
{
    public function __construct()
    {
    }

    public static function createReleaseSprint(
        string            $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    ): Sprint
    {
        return new ReleaseSprint($name, $startDate, $endDate);
    }

    public static function createPartialProductSPrint(
        string            $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    ): Sprint
    {
        return new PartialProductSprint($name, $startDate, $endDate);
    }
}
