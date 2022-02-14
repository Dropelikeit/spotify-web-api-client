<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Tests\Facade;

use MarcelStrahl\SpotifyWebApiClient\Client\SpotifyQrClient;
use MarcelStrahl\SpotifyWebApiClient\Facade\SpotifyQrClientFacade;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class SpotifyQrClientFacadeTest extends TestCase
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
        $facade = new SpotifyQrClientFacade($this->requestFactory);

        $client = $facade->buildInstance();

        $this->assertInstanceOf(SpotifyQrClient::class, $client);
    }
}
