<?php

namespace App\ExchangeRates\Exception;

use RuntimeException;
use Throwable;

class ServiceUnavailableException extends RuntimeException
{
    /**
     * ServiceUnavailableException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Service temporarily unavailable. Please try again later.';
        }

        parent::__construct($message, $code, $previous);
    }
}
