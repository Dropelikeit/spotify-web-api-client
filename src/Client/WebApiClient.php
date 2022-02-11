<?php

declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use MarcelStrahl\SpotifyWebApiClient\Exception\FetchTrackException;
use MarcelStrahl\SpotifyWebApiClient\Model\Track;
use Psr\Http\Message\RequestFactoryInterface;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiClient implements WebApiClientInterface
{
    private const HTTP_METHOD_GET = 'GET';
    private const API_ROUTE_GET_TRACK_BY_ID = '/v1/tracks/%s';

    private ClientInterface $client;
    private RequestFactoryInterface $requestFactory;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
    }

    public function getTrackById(string $trackId): Track
    {
        $request = $this->requestFactory->createRequest(
            self::HTTP_METHOD_GET,
            sprintf(self::API_ROUTE_GET_TRACK_BY_ID, $trackId)
        );

        try {
            $response = $this->client->send($request);
        } catch (GuzzleException $exception) {
            throw FetchTrackException::createByGuzzleClient($exception);
        }

        $responseData = (string) $response->getBody();
        Assert::stringNotEmpty($responseData);

        try {
            $content = json_decode($responseData, true, 512, JSON_THROW_ON_ERROR);

            Assert::isArray($content);
            Assert::isMap($content);
        } catch (JsonException $exception) {
            throw FetchTrackException::createByJsonException($exception);
        }

        return Track::create($content);
    }

}
