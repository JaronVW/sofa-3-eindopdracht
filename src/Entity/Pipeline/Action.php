<?php

namespace App\Entity\Pipeline;

use App\Entity\Exceptions\PipelineFailedException;

class Action implements DevopsAction
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * @throws PipelineFailedException
     */
    public function execute(): string
    {
        // This is a dummy implementation of the execute method
        if($this->name !== "failtest"){
            throw new PipelineFailedException();
        }
        return $this->name;
    }

}
