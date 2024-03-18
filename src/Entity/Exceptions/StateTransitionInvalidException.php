<?php

namespace App\Entity\Exceptions;

use Exception;
use Throwable;

class StateTransitionInvalidException extends Exception
{
    public function __construct($message = "Method is not possible", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
