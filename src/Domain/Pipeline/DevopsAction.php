<?php

namespace App\Domain\Pipeline;

interface DevopsAction
{
    public function __construct(string $name);

    public function execute();

}
