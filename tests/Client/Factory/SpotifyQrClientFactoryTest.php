<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Tests\Facade;

use MarcelStrahl\SpotifyWebApiClient\Client\Factory\SpotifyQrClientFactory;
use MarcelStrahl\SpotifyWebApiClient\Client\SpotifyQrClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class SpotifyQrClientFactoryTest extends TestCase
{
    /**
     * @psalm-var MockObject&RequestFactoryInterface
     */
    private MockObject $requestFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->requestFactory = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();
    }

    /**
     * @test
     */
    public function canInitInstance(): void
    {
        $facade = new SpotifyQrClientFactory($this->requestFactory);

        $client = $facade->buildInstance();

        $this->assertInstanceOf(SpotifyQrClient::class, $client);
    }
}
