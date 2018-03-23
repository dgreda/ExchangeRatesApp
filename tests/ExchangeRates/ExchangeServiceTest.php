<?php

declare(strict_types=1);

namespace App\Tests\ExchangeRates;

use App\Entity\ExchangeEnquiry;
use App\ExchangeRates\ExchangeService;
use App\ExchangeRates\Provider\ProviderInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExchangeServiceTest extends KernelTestCase
{
    /**
     * @var ProviderInterface|ObjectProphecy
     */
    protected $providerProphecy;

    public function setUp()
    {
        static::bootKernel();

        $this->providerProphecy = $this->prophesize()->willImplement(ProviderInterface::class);
    }

    /**
     * @param string $baseCurrency
     * @param string $targetCurrency
     * @param float  $exchangeRate
     *
     * @dataProvider getExchangeRateProvider
     */
    public function testGetExchangeRate(string $baseCurrency, string $targetCurrency, float $exchangeRate)
    {
        $this->providerProphecy->getLatestExchangeRate($baseCurrency, $targetCurrency)->willReturn($exchangeRate);

        $exchangeService = $this->makeExchangeService();

        $this->assertSame($exchangeRate, $exchangeService->getExchangeRate($baseCurrency, $targetCurrency));

        $this->providerProphecy
            ->getLatestExchangeRate($baseCurrency, $targetCurrency)
            ->shouldHaveBeenCalledTimes(1);
    }

    /**
     * @return array
     */
    public function getExchangeRateProvider(): array
    {
        return [
            [
                'baseCurrency'   => 'EUR',
                'targetCurrency' => 'PLN',
                'exchangeRate'   => 4.2,
            ],
            [
                'baseCurrency'   => 'USD',
                'targetCurrency' => 'CAD',
                'exchangeRate'   => 1.24,
            ],
        ];
    }

    /**
     * @param ExchangeEnquiry $enquiry
     * @param float           $exchangeRate
     *
     * @dataProvider exchangeDataProvider
     */
    public function testExchange(ExchangeEnquiry $enquiry, float $exchangeRate)
    {
        $this->providerProphecy->getLatestExchangeRate(
            $enquiry->getBaseCurrency(),
            $enquiry->getTargetCurrency()
        )->willReturn($exchangeRate);

        $exchangeService = $this->makeExchangeService();

        $exchangedAmount = $exchangeService->exchange($enquiry);
        $this->assertSame($enquiry->getAmount() * $exchangeRate, $exchangedAmount);
    }

    /**
     * @return array
     */
    public function exchangeDataProvider(): array
    {
        return [
            [
                'enquiry'      => new ExchangeEnquiry(
                    1000.00,
                    'EUR',
                    'PLN'
                ),
                'exchangeRate' => 4.2,
            ],
            [
                'enquiry'      => new ExchangeEnquiry(
                    9999.00,
                    'CAD',
                    'USD'
                ),
                'exchangeRate' => 0.81,
            ],
            [
                'enquiry'      => new ExchangeEnquiry(
                    null,
                    null,
                    null
                ),
                'exchangeRate' => 4.2,
            ],
        ];
    }

    public function testGetSupportedCurrencies()
    {
        $supportedCurrencies = ['EUR', 'USD'];
        $this->providerProphecy->getSupportedCurrencies()->willReturn($supportedCurrencies);

        $exchangeService = $this->makeExchangeService();

        $this->assertSame($supportedCurrencies, $exchangeService->getSupportedCurrencies());
    }

    /**
     * @return ExchangeService
     */
    private function makeExchangeService(): ExchangeService
    {
        $exchangeService = new ExchangeService(
            $this->providerProphecy->reveal(),
            static::$kernel->getContainer()->get('test.App\ExchangeRates\Calculator')
        );

        return $exchangeService;
    }
}
