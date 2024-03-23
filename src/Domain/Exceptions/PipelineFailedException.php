<?php

namespace App\Domain\Exceptions;

use Exception;
use Throwable;

class PipelineFailedException extends Exception
{
    public function __construct($message = "Pipeline failed", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
