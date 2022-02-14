<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Tests\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\StreamFactory;
use MarcelStrahl\SpotifyWebApiClient\Client\SpotifyQrClient;
use MarcelStrahl\SpotifyWebApiClient\Exception\QrCodeException;
use MarcelStrahl\SpotifyWebApiClient\Model\SpotifyQrClient\QrCodePreference;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class SpotifyQrClientTest extends TestCase
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
    public function canFetchQrCode(): void
    {
        $client = new SpotifyQrClient($this->client, $this->requestFactory);

        $request = new Request(
            '/downloadCode.php?uri=jpeg%2F000000%2Fwhite%2F640%2Fspotify%3Atrack%3A4xkOaSrkexMciUUogZKVTS',
            'GET'
        );
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with(
                'GET',
                '/downloadCode.php?uri=jpeg%2F000000%2Fwhite%2F640%2Fspotify%3Atrack%3A4xkOaSrkexMciUUogZKVTS'
            )
            ->willReturn($request);

        $response = new Response(
            200,
            [],
            (new StreamFactory())->createStream('File Dummy'),
        );

        $this->client
            ->expects(self::once())
            ->method('send')
            ->with($request)
            ->willReturn($response);

        $client->fetchQrCode(QrCodePreference::create(
            '000000',
            QrCodePreference::BAR_COLOR_WHITE,
            640,
            QrCodePreference::FORMAT_JPEG,
            'spotify:track:4xkOaSrkexMciUUogZKVTS',
        ));
    }

    /**
     * @test
     */
    public function cannotRetrieveBecauseAGuzzleclientExceptionIsThrown(): void
    {
        $this->expectException(QrCodeException::class);

        $client = new SpotifyQrClient($this->client, $this->requestFactory);

        $request = new Request(
            '/downloadCode.php?uri=jpeg%2F000000%2Fwhite%2F640%2Fspotify%3Atrack%3A4xkOaSrkexMciUUogZKVTS',
            'GET'
        );
        $this->requestFactory
            ->expects(self::once())
            ->method('createRequest')
            ->with(
                'GET',
                '/downloadCode.php?uri=jpeg%2F000000%2Fwhite%2F640%2Fspotify%3Atrack%3A4xkOaSrkexMciUUogZKVTS'
            )
            ->willReturn($request);

        $this->client
            ->expects(self::once())
            ->method('send')
            ->with($request)
            ->willThrowException(new ClientException('errors', $request, new Response(500)));

        $client->fetchQrCode(QrCodePreference::create(
            '000000',
            QrCodePreference::BAR_COLOR_WHITE,
            640,
            QrCodePreference::FORMAT_JPEG,
            'spotify:track:4xkOaSrkexMciUUogZKVTS',
        ));
    }
}
