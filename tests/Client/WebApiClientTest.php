<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Tests\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\StreamFactory;
use MarcelStrahl\SpotifyApiClient\Client\WebApiClient;
use MarcelStrahl\SpotifyApiClient\Exception\FetchTrackException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiClientTest extends TestCase
{
    /**
     * @psalm-var MockObject&ClientInterface
     */
    private MockObject $client;

    /**
     * @psalm-var MockObject&RequestFactoryInterface
     */
    private MockObject $requestFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $this->requestFactory = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();
    }

    /**
     * @test
     */
    public function canFetchTrackById(): void
    {
        $client = new WebApiClient($this->client, $this->requestFactory);

        $request = new Request('/v1/tracks/sdasdwasd', 'GET');
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with('GET', '/v1/tracks/sdasdwasd')
            ->willReturn($request);

        $response = new Response(
            200,
            ['Accept' => 'application/json', 'Content-Type' => 'application/json'],
            (new StreamFactory())->createStream($this->getResponseBodyContent()),
        );

        $this->client
            ->expects(self::once())
            ->method('send')
            ->with($request)
            ->willReturn($response);

        $track = $client->getTrackById('sdasdwasd');

        $this->assertSame('sdasdwasd', $track->getId());
    }

    /**
     * @test
     */
    public function cannotRetrieveBecauseAGuzzleclientExceptionIsThrown(): void
    {
        $this->expectException(FetchTrackException::class);

        $client = new WebApiClient($this->client, $this->requestFactory);

        $request = new Request('/v1/tracks/sdasdwasd', 'GET');
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with('GET', '/v1/tracks/sdasdwasd')
            ->willReturn($request);

        $this->client
            ->expects(self::once())
            ->method('send')
            ->with($request)
            ->willThrowException(new ClientException('errors', $request, new Response(500)));

        $client->getTrackById('sdasdwasd');
    }

    /**
     * @test
     */
    public function cannotRetrieveBecauseJsonExceptionIsThrown(): void
    {
        $this->expectException(FetchTrackException::class);

        $client = new WebApiClient($this->client, $this->requestFactory);

        $request = new Request('/v1/tracks/sdasdwasd', 'GET');
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with('GET', '/v1/tracks/sdasdwasd')
            ->willReturn($request);

        $response = new Response(
            200,
            [],
            (new StreamFactory())->createStream('some text'),
        );

        $this->client
            ->expects(self::once())
            ->method('send')
            ->with($request)
            ->willReturn($response);

        $client->getTrackById('sdasdwasd');
    }

    /**
     * @psalm-return non-empty-string
     */
    private function getResponseBodyContent(): string
    {
        $json = (string) include __DIR__ . '/webapiclient_track_response.php';
        Assert::stringNotEmpty($json);

        return $json;
    }
}
