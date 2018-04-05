<?php

declare(strict_types = 1);

namespace App\Http;

use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\Psr6CacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ClientFactory
{
    /**
     * @var GuzzleFactory
     */
    protected $guzzleFactory;

    /**
     * ClientFactory constructor.
     *
     * @param GuzzleFactory $guzzleFactory
     */
    public function __construct(GuzzleFactory $guzzleFactory)
    {
        $this->guzzleFactory = $guzzleFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @return ClientInterface
     */
    public function make(): ClientInterface
    {
        $stack                = HandlerStack::create();
        $cacheStorage         = new Psr6CacheStorage(
            new FilesystemAdapter('ExchangeRatesApp', 0, '/tmp/')
        );
        $privateCacheStrategy = new PrivateCacheStrategy($cacheStorage);

        $stack->push(new CacheMiddleware($privateCacheStrategy), 'cache');

        return $this->guzzleFactory::make(['handler' => $stack]);
    }
}
