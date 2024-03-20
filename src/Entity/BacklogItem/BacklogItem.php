<?php

namespace App\Entity\BacklogItem;

use App\Entity\BacklogActivity;
use App\Entity\BacklogItem\States\BacklogItemState;
use App\Entity\BacklogItem\States\TodoState;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Exceptions\StateTransitionInvalidException;
use App\Entity\Observer\NotificationManager;
use App\Entity\Users\User;

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
        private ?User                        $developer
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

    public function getDeveloper(): ?User
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

}
