<?php

declare(strict_types = 1);

namespace App\ExchangeRates;

class Calculator implements CalculatorInterface
{
    /**
     * @param float $baseAmount
     * @param float $exchangeRate
     *
     * @return float
     */
    public function exchange(float $baseAmount, float $exchangeRate): float
    {
        return $baseAmount * $exchangeRate;
    }
}
