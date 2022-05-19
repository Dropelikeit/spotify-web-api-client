<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client\Factory;

use GuzzleHttp\Client;
use MarcelStrahl\SpotifyWebApiClient\Client\SpotifyQrClient;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class SpotifyQrClientFactory
{
    private const BASE_URI = 'https://www.spotifycodes.com';

    private RequestFactoryInterface $requestFactory;

    public function __construct(RequestFactoryInterface $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    public function buildInstance(): SpotifyQrClient\SpotifyQrClientInterface
    {
        $client = new Client(['base_uri' => self::BASE_URI]);

        return new SpotifyQrClient($client, $this->requestFactory);
    }
}
