<?php

namespace App\Entity\Threads;

use App\Entity\BacklogItem\BacklogItem;
use App\Entity\BacklogItem\States\DoneState;
use App\Entity\Exceptions\ModificationNotAllowedException;
use App\Entity\Sprint\States\Release\ReleaseCreatedState;
use App\Entity\Sprint\States\Release\ReleaseFinishedState;

class Thread
{
    /**
     * @var array<int,Comment>
     */
    private array $comments = [];

    public function __construct(
        private string      $topic,
        private string      $content,
        private BacklogItem $backlogItem
    )
    {
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function addComment(Comment $comment): void
    {
        if ($this->modifyThreadAllowed()) {
            $this->comments[] = $comment;
        }
    }

    /**
     * @throws ModificationNotAllowedException
     */
    private function modifyThreadAllowed(): bool
    {
        if ($this->backlogItem->getState() instanceof DoneState) {
            throw new ModificationNotALlowedException();
        }
        return true;
    }


    public function getTopic(): string
    {
        return $this->topic;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setTopic(string $topic): void
    {
        if ($this->modifyThreadAllowed()) {
            $this->topic = $topic;
        }
    }

    /**
     * @throws ModificationNotAllowedException
     */
    public function setContent(string $content): void
    {
        if ($this->modifyThreadAllowed()) {
            $this->content = $content;
        }
    }

    public function getComments(): array
    {
        return $this->comments;
    }
}
