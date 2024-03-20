<?php

namespace App\Entity\Sprint;

use App\Entity\Backlog;
use App\Entity\BacklogItem\BacklogItem;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Sprint\States\Release\ReleaseCreatedState;
use App\Entity\Sprint\States\SprintState;
use App\Entity\User;
use DateTimeImmutable;

abstract class Sprint
{

    private SprintState $state;
    private Backlog $backlog;

    private array $developers = [];


    public function __construct(
        private string            $name,
        private DateTimeImmutable $startDate,
        private DateTimeImmutable $endDate,
        private User $scrumMaster,
        private ?user $productOwner = null
    )
    {
        $this->state = new ReleaseCreatedState();
        $this->backlog = new Backlog();
    }

    /**
     * @throws ModificationNotAllowedException
     */

    /**
     * @throws ModificationNotAllowedException
     */
    public function addBacklogItem(BacklogItem $backlogItem): void
    {
        if ($this->modifySprintAllowed()) {
            $this->backlog->addBacklogItem($backlogItem);
        }
    }

    public function getBacklogItems(): array
    {
        return $this->backlog->getBacklogItems();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }
    public function setState(SprintState $state): void
    {
        $this->state = $state;
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setName(string $name): void
    {
        if ($this->modifySprintAllowed()) {
            $this->name = $name;
        }
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setStartDate(DateTimeImmutable $startDate): void
    {
        if ($this->modifySprintAllowed()) {
            $this->startDate = $startDate;
        }
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setEndDate(DateTimeImmutable $endDate): void
    {
        if ($this->modifySprintAllowed()) {
            $this->endDate = $endDate;
        }
    }

    private function modifySprintAllowed(): bool
    {
        if ($this->state instanceof ReleaseCreatedState) {
            return true;
        } else {
            throw new ModificationNotALlowedException();
        }
    }
}
