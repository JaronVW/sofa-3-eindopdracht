<?php

namespace App\Entity\Sprint;

use App\Entity\Sprint\States\PartialProduct\PartialProductCreatedState;
use App\Entity\Sprint\States\PartialProduct\PartialProductFinishedState;
use App\Entity\Sprint\States\SprintState;
use App\Entity\Users\ProductOwner;
use App\Entity\Users\ScrumMaster;
use DateTimeImmutable;
use PHPStan\PhpDocParser\Ast\PhpDoc\TypeAliasImportTagValueNode;

class PartialProductSprint extends Sprint
{
    public function __construct(string $name, DateTimeImmutable $startDate, DateTimeImmutable $endDate, ScrumMaster $scrumMaster, ?ProductOwner $productOwner = null)
    {
        parent::__construct($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->state = new PartialProductCreatedState();
    }

    public function progressSprint(): void
    {
        $this->state = new PartialProductFinishedState();
    }

    public function cancelSprint(): void
    {
        $this->state = new PartialProductCancelledState();
    }
}
