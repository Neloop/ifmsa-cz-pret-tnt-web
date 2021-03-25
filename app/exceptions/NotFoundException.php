<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Not found exception is used mainly in doctrine repositories as indication
 * that entity with particular filtering options cannot be found in database.
 */
class NotFoundException extends Exception
{
    /**
     * Constructor.
     * @param string $message
     * @param Throwable|null $previous defaulted on null
     */
    public function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
