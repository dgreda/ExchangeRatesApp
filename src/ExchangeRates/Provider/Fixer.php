<?php

declare(strict_types=1);

namespace App\ExchangeRates\Provider;

use App\ExchangeRates\Exception\ServiceUnavailableException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class Fixer implements ProviderInterface
{
    protected const REQUEST_METHOD = 'GET';

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct(string $baseUri, string $token, ClientInterface $client)
    {
        $this->baseUri = $baseUri;
        $this->token   = $token;
        $this->client  = $client;
    }

    /**
     * @param string $baseCurrency
     * @param string $targetCurrency
     *
     * @return float
     *
     * @throws ServiceUnavailableException
     */
    public function getLatestExchangeRate(string $baseCurrency, string $targetCurrency): float
    {
        $baseCurrency   = strtoupper($baseCurrency);
        $targetCurrency = strtoupper($targetCurrency);

        if ($baseCurrency === $targetCurrency) {
            return 1.0;
        }

        try {
            $response = $this->client->request(
                static::REQUEST_METHOD,
                $this->baseUri,
                [
                    'query' => [
                        'base'       => $baseCurrency,
                        'access_key' => $this->token,
                    ],
                ]
            );

            $responseAsStdObject = \GuzzleHttp\json_decode($response->getBody());
        } catch (GuzzleException $e) {
            throw new ServiceUnavailableException('', 504, $e);
        }

        if (!property_exists($responseAsStdObject->rates, $targetCurrency)) {
            throw new ServiceUnavailableException(
                'We\'re currently experiencing some problems, please try again shortly or contact us.'
            );
        }

        return (float) $responseAsStdObject->rates->{$targetCurrency};
    }

    /**
     * @return array
     *
     * @throws ServiceUnavailableException
     */
    public function getSupportedCurrencies(): array
    {
        try {
            $response = $this->client->request(
                static::REQUEST_METHOD,
                $this->baseUri,
                [
                    'query' => [
                        'access_key' => $this->token,
                    ],
                ]
            );

            $responseAsArray = \GuzzleHttp\json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new ServiceUnavailableException('', 504, $e);
        }

        if (empty($responseAsArray['rates'])) {
            throw new ServiceUnavailableException(
                'We\'re currently experiencing some problems, please try again shortly or contact us.'
            );
        }

        return array_keys($responseAsArray['rates']);
    }
}
