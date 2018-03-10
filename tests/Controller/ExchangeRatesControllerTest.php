<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExchangeRatesControllerTest extends WebTestCase
{
    public function testExchange()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            1,
            $crawler->filter('html:contains("ExchangeRatesApp")')->count()
        );

        $form = $crawler->selectButton('Exchange!')->form();

        $form['exchange_enquiry[amount]']         = '123.45';
        $form['exchange_enquiry[targetCurrency]'] = 'PLN';

        $crawler = $client->submit($form);

        $this->assertEquals(
            1,
            $crawler->filter('html:contains("123.45 EUR in PLN = ")')->count()
        );
    }
}
