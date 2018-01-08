<?php

declare(strict_types=1);

namespace App\Tests\ExchangeRates;

use App\ExchangeRates\Calculator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @param float $baseAmount
     * @param float $exchangeRate
     * @param float $expectedAmount
     *
     * @dataProvider exchangeDataProvider
     */
    public function testExchange(float $baseAmount, float $exchangeRate, float $expectedAmount)
    {
        $calculator = new Calculator();

        $this->assertSame($expectedAmount, $calculator->exchange($baseAmount, $exchangeRate));
    }

    /**
     * @return array
     */
    public function exchangeDataProvider(): array
    {
        return [
            [
                'baseAmount'     => 100,
                'exchangeRate'   => 2,
                'expectedAmount' => 200,
            ],
            [
                'baseAmount'     => 7000,
                'exchangeRate'   => 0.24064,
                'expectedAmount' => 1684.48,
            ],
            [
                'baseAmount'     => 164.4987651898,
                'exchangeRate'   => 9.46998438,
                'expectedAmount' => 1557.800736876693735,
            ],
        ];
    }
}
