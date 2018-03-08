<?php

declare(strict_types=1);

namespace App\ExchangeRates;

use App\Entity\ExchangeEnquiry;
use App\ExchangeRates\Provider\ProviderInterface;

class ExchangeService
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * @var CalculatorInterface
     */
    protected $calculator;

    /**
     * Exchange constructor.
     *
     * @param ProviderInterface   $provider
     * @param CalculatorInterface $calculator
     */
    public function __construct(ProviderInterface $provider, CalculatorInterface $calculator)
    {
        $this->provider   = $provider;
        $this->calculator = $calculator;
    }

    /**
     * @param string $baseCurrency   ISO 4217 Currency Code of base currency
     * @param string $targetCurrency ISO 4217 Currency Code of base currency
     *
     * @return float
     */
    public function getExchangeRate(string $baseCurrency, string $targetCurrency): float
    {
        return $this->provider->getLatestExchangeRate($baseCurrency, $targetCurrency);
    }

    /**
     * @param ExchangeEnquiry $enquiry
     *
     * @return float
     */
    public function exchange(ExchangeEnquiry $enquiry): float
    {
        $exchangeRate = $this->provider->getLatestExchangeRate(
            $enquiry->getBaseCurrency(),
            $enquiry->getTargetCurrency()
        );

        return $this->calculator->exchange($enquiry->getAmount(), $exchangeRate);
    }

    /**
     * @return array
     */
    public function getSupportedCurrencies(): array
    {
        return $this->provider->getSupportedCurrencies();
    }
}
