<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client\Factory;

use GuzzleHttp\Client;
use MarcelStrahl\SpotifyWebApiClient\Client\WebApiClient\WebApiAuth;
use MarcelStrahl\SpotifyWebApiClient\Client\WebApiClient\WebApiAuthInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiAuthFactory
{
    private const BASE_URI = 'https://accounts.spotify.com';

    private RequestFactoryInterface $requestFactory;

    public function __construct(RequestFactoryInterface $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    public function buildInstance(): WebApiAuthInterface
    {
        $client = new Client([
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        return new WebApiAuth($client, $this->requestFactory);
    }
}
