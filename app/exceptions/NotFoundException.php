<?php

namespace App\Exceptions;

/**
 * Not found exception is used mainly in doctrine repositories as indication
 * that entity with particular filtering options cannot be found in database.
 */
class NotFoundException extends \Exception
{
    /**
     * Constructor.
     * @param type $message
     * @param type $previous defaulted on null
     */
    public function __construct($message, $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
