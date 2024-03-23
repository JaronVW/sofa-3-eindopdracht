<?php

namespace App\Domain\BacklogItem;

use App\Domain\BacklogItem\EffortPointCount;
use App\Domain\BacklogActivity;
use App\Domain\BacklogItem\States\BacklogItemState;
use App\Domain\BacklogItem\States\TodoState;
use App\Domain\Exceptions\ModificationNotAllowedException;
use App\Domain\Exceptions\StateTransitionInvalidException;
use App\Domain\Observer\NotificationManager;
use App\Domain\Users\Developer;
use App\Domain\Users\User;

class BacklogItem
{

    private bool $done = false;
    private BacklogItemState $state;

    /**
     * @var array<int,BacklogActivity>
     */
    private array $backlogActivities = [];

    public function __construct(
        public readonly string               $title,
        public readonly string               $description,
        private readonly NotificationManager $notificationManager,
        private ?Developer                   $developer,
        private EffortPointCount             $effortPoints

    )
    {
        $this->state = new TodoState($this->notificationManager);
    }

    public function getBacklogActivities(): array
    {
        return $this->backlogActivities;
    }

    public function addBacklogActivity(BacklogActivity $backlogActivity): void
    {
        $this->backlogActivities[] = $backlogActivity;
    }

    public function getDeveloper(): ?Developer
    {
        return $this->developer;
    }

    public function getState(): BacklogItemState
    {
        return $this->state;
    }

    /**
     * @throws StateTransitionInvalidException
     */
    public function progressState(): void
    {
        $this->state = $this->state->progressState();
    }

    /**
     * @throws StateTransitionInvalidException
     */
    public function regressState(): void
    {
        $this->state = $this->state->regressState();
    }

    public function setDeveloper(?User $developer): void
    {
        $this->developer = $developer;
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setDone(): void
    {
        foreach ($this->backlogActivities as $backlogActivity) {
            if ($backlogActivity->isDone() === false) {
                throw new ModificationNotAllowedException();
            }
        }
        $this->done = true;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function getEffortPoints(): int
    {
        return $this->effortPoints;
    }

    public function setEffortPoints(int $effortPoints): void
    {
        $this->effortPoints = $effortPoints;
    }

}
