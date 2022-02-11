<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Facade;

use GuzzleHttp\Client;
use MarcelStrahl\SpotifyWebApiClient\Client\WebApiClient;
use MarcelStrahl\SpotifyWebApiClient\Client\WebApiClientInterface;
use MarcelStrahl\SpotifyWebApiClient\Model\AccessToken;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiClientFacade
{
    private const BASE_URI = 'https://api.spotify.com';

    private RequestFactoryInterface $requestFactory;

    public function __construct(RequestFactoryInterface $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    public function buildInstance(AccessToken $accessToken): WebApiClientInterface
    {
        $client = new Client([
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $accessToken->getToken()),
            ],
        ]);

        return new WebApiClient($client, $this->requestFactory);
    }
}
