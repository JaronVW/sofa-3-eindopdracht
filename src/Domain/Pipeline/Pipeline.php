<?php

namespace App\Domain\Pipeline;

use App\Domain\Exceptions\PipelineFailedException;
use Exception;

class Pipeline
{
    private bool $pipeLineBusy = false;
    private bool $pipeLineFailed = false;


    /**
     * @var array<int,DevopsAction>
     */
    private array $actions = [];

    public function __construct()
    {
    }

    public function addAction(DevopsAction $action): void
    {
        $this->actions[] = $action;
    }

    /**
     * @throws PipelineFailedException
     */
    public function execute(): void
    {
        $this->pipeLineFailed = false;
        $this->pipeLineBusy = true;
        // sleep 5 sec for testing purposes
//        sleep(5);
        try {
            foreach ($this->actions as $action) {
                $action->execute();
            }

        } catch (Exception) {
            $this->pipeLineFailed = true;
            $this->pipeLineBusy = false;
            throw new PipelineFailedException();
        }

        $this->pipeLineBusy = false;
    }

    public function isPipeLineBusy(): bool
    {
        return $this->pipeLineBusy;
    }

    public function setPipeLineBusy(bool $pipeLineBusy): void
    {
        $this->pipeLineBusy = $pipeLineBusy;
    }

    public function didPipeLineFail(): bool
    {
        return $this->pipeLineFailed;
    }

    public function setPipeLineFailed(bool $pipeLineFailed): void
    {
        $this->pipeLineFailed = $pipeLineFailed;
    }
}
