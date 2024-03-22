<?php

namespace App\Entity\Pipeline;

interface DevopsAction
{
    public function __construct(string $name);

    public function execute();

}
