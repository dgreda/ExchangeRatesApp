<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ExchangeEnquiry
{
    /**
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     *
     * @var float Amount to exchange
     */
    protected $amount;

    /**
     * @Assert\NotBlank
     * @Assert\Currency
     *
     * @var string ISO 4217 Currency Code of base currency
     */
    protected $baseCurrency;

    /**
     * @Assert\NotBlank
     * @Assert\Currency
     *
     * @var string ISO 4217 Currency Code of target currency
     */
    protected $targetCurrency;

    /**
     * ExchangeEnquiry constructor.
     *
     * @param float|null  $amount         Amount to exchange
     * @param string|null $baseCurrency   ISO 4217 Currency Code of base currency
     * @param string|null $targetCurrency ISO 4217 Currency Code of target currency
     */
    public function __construct(float $amount = null, string $baseCurrency = null, string $targetCurrency = null)
    {
        $this->amount         = $amount ? $amount : 0.0;
        $this->baseCurrency   = $baseCurrency ? $baseCurrency : '';
        $this->targetCurrency = $targetCurrency ? $targetCurrency : '';
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param string $baseCurrency
     */
    public function setBaseCurrency(string $baseCurrency): void
    {
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @param string $targetCurrency
     */
    public function setTargetCurrency(string $targetCurrency): void
    {
        $this->targetCurrency = $targetCurrency;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    /**
     * @return string
     */
    public function getTargetCurrency(): string
    {
        return $this->targetCurrency;
    }
}
