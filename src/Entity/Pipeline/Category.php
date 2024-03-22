<?php

namespace App\Entity\Pipeline;

use App\Entity\Exceptions\PipelineFailedException;

class Category implements DevopsAction
{
    /**
     * @param array<int,DevopsAction> $devopsActions
     */
    private array $devopsActions = [];

    public function __construct(string $name)
    {
    }

    public function add(DevopsAction $devopsAction): void
    {
        $this->devopsActions[] = $devopsAction;
    }

    public function remove(DevopsAction $devopsAction): void
    {
        $key = array_search($devopsAction, $this->devopsActions);
        if ($key !== false) {
            unset($this->devopsActions[$key]);
        }
    }

    public function getDevopsActions(): array
    {
        return $this->devopsActions;
    }

    /**
     * @throws PipelineFailedException
     */
    public function execute(): void
    {
        foreach ($this->devopsActions as $devopsAction) {
            $devopsAction->execute();
        }
    }
