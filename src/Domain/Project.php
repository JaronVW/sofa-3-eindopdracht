<?php

namespace App\Domain;

use App\Domain\Backlog\Backlog;
use App\Domain\Backlog\BacklogItem\BacklogItem;
use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Sprint\Sprint;
use App\Domain\Sprint\SprintFactory;
use App\Domain\Users\ProductOwner;
use App\Domain\Users\ScrumMaster;
use DateTimeImmutable;

class Project
{
    /**
     * @var array<string, Sprint>
     */
    private array $sprints = [];

    private Backlog $backlog;

    public function __construct(
    )
    {
        $this->backlog = new Backlog();
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
        $this->sprints[$name] = $sprint;
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
        $this->sprints[$name] = $sprint;
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

    /**
     * @return array<int, \App\Domain\Backlog\BacklogItem\BacklogItem>
     */
    public function getBacklogItems(): array
    {
       return $this->backlog->getBacklogItems();
    }

    public function getSprint(string $name): Sprint
    {
        return $this->sprints[$name];
    }

}
