<?php

namespace App\ExchangeRates\Exception;

use RuntimeException;
use Throwable;

class ServiceUnavailableException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Service temporarily unavailable. Please try again later.';
        }

        parent::__construct($message, $code, $previous);
    }
}
