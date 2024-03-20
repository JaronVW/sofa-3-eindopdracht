<?php

namespace App\Entity\Exceptions;

use Exception;

class InvalidEffortPointException extends Exception
{
    public function __construct($message = "Not a valid amount of effort points", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
