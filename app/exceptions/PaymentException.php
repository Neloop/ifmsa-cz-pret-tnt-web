<?php

namespace App\Exceptions;

use Exception;

/**
 * Used in payment helpers as indication of critical error during starting or
 * retrieving transaction from remote server.
 */
class PaymentException extends Exception
{
    /**
     * Constructor.
     * @param string $message
     * @param Exception $previous defaulted on null
     */
    public function __construct($message, $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
