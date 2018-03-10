<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExchangeRatesControllerTest extends WebTestCase
{
    public function testExchange()
    {
        $amount         = 123.45;
        $targetCurrency = 'PLN';
        $client         = static::createClient();
        $crawler        = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            1,
            $crawler->filter('html:contains("ExchangeRatesApp")')->count()
        );

        $form = $crawler->selectButton('Exchange!')->form();

        $form['exchange_enquiry[amount]'] = $amount;

        $crawler = $client->submit($form);

        $this->assertEquals(
            1,
            $crawler->filter('html:contains("' . $amount . ' EUR in EUR = ' . $amount . '")')->count()
        );

        $form['exchange_enquiry[targetCurrency]'] = $targetCurrency;

        $crawler = $client->submit($form);

        $this->assertEquals(
            1,
            $crawler->filter('html:contains("' . $amount . ' EUR in ' . $targetCurrency . ' = ")')->count()
        );
    }
}
