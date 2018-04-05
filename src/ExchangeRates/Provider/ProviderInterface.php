<?php

declare(strict_types = 1);

namespace App\ExchangeRates\Provider;

interface ProviderInterface
{
    /**
     * @param string $baseCurrency
     * @param string $targetCurrency
     *
     * @return float
     */
    public function getLatestExchangeRate(string $baseCurrency, string $targetCurrency): float;

    /**
     * @return array
     */
    public function getSupportedCurrencies(): array;
}
