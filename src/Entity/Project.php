<?php

namespace App\Entity;

use App\Entity\BacklogItem\BacklogItem;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Sprint\Sprint;
use App\Entity\Sprint\SprintFactory;
use App\Entity\Users\ProductOwner;
use App\Entity\Users\ScrumMaster;
use DateTimeImmutable;

class Project
{
    /**
     * @var array<int, Sprint>
     */
    private array $sprints = [];

    public function __construct(
        private Backlog $backlog
    )
    {
    }

    public function createReleaseSprint(
        string            $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        ScrumMaster       $scrumMaster,
        ?ProductOwner     $productOwner = null
    ): void
    {
        $sprint = SprintFactory::createReleaseSprint($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->sprints[] = $sprint;
    }

    public function createPartialProductSprint(
        string            $name,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        ScrumMaster       $scrumMaster,
        ?ProductOwner     $productOwner = null
    ): void
    {
        $sprint = SprintFactory::createPartialProductSprint($name, $startDate, $endDate, $scrumMaster, $productOwner);
        $this->sprints[] = $sprint;
    }

    public function addBacklogItem(BacklogItem $backlogItem): void
    {
        $this->backlog->addBacklogItem($backlogItem);
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function moveToSprint(BacklogItem $backlogItem, Sprint $sprint): void
    {
        $this->backlog->removeBacklogItem($backlogItem);
        $sprint->addBacklogItem($backlogItem);
    }
}
