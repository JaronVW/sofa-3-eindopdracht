<?php

namespace App\Entity\Exceptions;

use Exception;

class ModificationNotAllowedException extends Exception
{
    public function __construct($message = "Modification is not allowed", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
