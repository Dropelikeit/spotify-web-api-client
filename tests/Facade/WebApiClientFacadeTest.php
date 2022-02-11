<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Tests\Facade;

use MarcelStrahl\SpotifyApiClient\Client\WebApiClient;
use MarcelStrahl\SpotifyApiClient\Facade\WebApiClientFacade;
use MarcelStrahl\SpotifyApiClient\Model\AccessToken;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use stdClass;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiClientFacadeTest extends TestCase
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
        $facade = new WebApiClientFacade($this->requestFactory);

        $standardClass = new stdClass();
        $standardClass->access_token = 'daskdmkwamld';
        $standardClass->token_type = 'token';
        $standardClass->expires_in = 3600;

        $client = $facade->buildInstance(
            AccessToken::create($standardClass)
        );

        $this->assertInstanceOf(WebApiClient::class, $client);
    }
}
