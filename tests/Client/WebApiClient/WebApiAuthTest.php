<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Tests\Client\WebApiClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\StreamFactory;
use MarcelStrahl\SpotifyApiClient\Client\WebApiClient\WebApiAuth;
use MarcelStrahl\SpotifyApiClient\Exception\WebApiAuthException;
use MarcelStrahl\SpotifyApiClient\Model\Credentials;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiAuthTest extends TestCase
{
    /**
     * @psalm-var MockObject&RequestFactoryInterface
     */
    private MockObject $requestFactory;

    /**
     * @psalm-var MockObject&ClientInterface
     */
    private MockObject $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->requestFactory = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();
        $this->client = $this->getMockBuilder(ClientInterface::class)->getMock();
    }

    /**
     * @test
     */
    public function canFetchAccessToken(): void
    {
        $credentials = Credentials::create([
            'clientId' => 'identifier',
            'clientSecret' => 'some-client-secret',
        ]);

        $client = new WebApiAuth($this->client, $this->requestFactory);

        $request = new Request('/api/token', 'POST');
        $request = $request
            ->withHeader('Authorization', sprintf(
                'Basic %s',
                base64_encode('identifier:some-client-secret')
            ))
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with('POST', '/api/token')
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

        $accessToken = $client->loadAccessToken($credentials);

        $this->assertSame('sdaksdlamlemfaldmklaw', $accessToken->getToken());
        $this->assertSame(3600, $accessToken->getExiresIn());
        $this->assertSame('Bearer', $accessToken->getType());
    }

    /**
     * @test
     */
    public function cannotRetrieveBecauseAGuzzleClientExceptionIsThrown(): void
    {
        $this->expectException(WebApiAuthException::class);

        $credentials = Credentials::create([
            'clientId' => 'identifier',
            'clientSecret' => 'some-client-secret',
        ]);

        $client = new WebApiAuth($this->client, $this->requestFactory);

        $request = new Request('/api/token', 'POST');
        $request = $request
            ->withHeader('Authorization', sprintf(
                'Basic %s',
                base64_encode('identifier:some-client-secret')
            ))
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with('POST', '/api/token')
            ->willReturn($request);

        $this->client
            ->expects(self::once())
            ->method('send')
            ->with($request)
            ->willThrowException(new ClientException('errors', $request, new Response(500)));

        $client->loadAccessToken($credentials);
    }

    /**
     * @test
     */
    public function cannotRetrieveBecauseJsonExceptionIsThrown(): void
    {
        $this->expectException(WebApiAuthException::class);

        $credentials = Credentials::create([
            'clientId' => 'identifier',
            'clientSecret' => 'some-client-secret',
        ]);

        $client = new WebApiAuth($this->client, $this->requestFactory);

        $request = new Request('/api/token', 'POST');
        $request = $request
            ->withHeader('Authorization', sprintf(
                'Basic %s',
                base64_encode('identifier:some-client-secret')
            ))
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with('POST', '/api/token')
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

        $client->loadAccessToken($credentials);
    }

    /**
     * @psalm-return non-empty-string
     */
    private function getResponseBodyContent(): string
    {
        return '{"access_token":"sdaksdlamlemfaldmklaw","token_type":"Bearer","expires_in":3600}';
    }
}
