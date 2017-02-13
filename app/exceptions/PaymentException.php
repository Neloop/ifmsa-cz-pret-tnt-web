<?php

namespace App\Exceptions;

/**
 *
 * @author Neloop
 */
class PaymentException extends \Exception
{
    public function __construct($message, $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
