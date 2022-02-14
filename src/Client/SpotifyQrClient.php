<?php

declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use MarcelStrahl\SpotifyWebApiClient\Client\SpotifyQrClient\SpotifyQrClientInterface;
use MarcelStrahl\SpotifyWebApiClient\Exception\QrCodeException;
use MarcelStrahl\SpotifyWebApiClient\Model\SpotifyQrClient\QrCodePreference;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamInterface;
use function sprintf;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class SpotifyQrClient extends Decoder implements SpotifyQrClientInterface
{
    private const QR_CODE_ENDPOINT = '/downloadCode.php?uri=%s';

    private ClientInterface $guzzleClient;
    private RequestFactoryInterface $requestFactory;

    public function __construct(
        ClientInterface $guzzleClient,
        RequestFactoryInterface $requestFactory,
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->requestFactory = $requestFactory;
    }

    /**
     * @throws QrCodeException
     */
    public function fetchQrCode(QrCodePreference $qrCodePreference): StreamInterface
    {
        $uriParameter = $this->buildUriQuery($qrCodePreference);
        $uriParameter = urlencode($uriParameter);
        Assert::stringNotEmpty($uriParameter);

        $request = $this->requestFactory->createRequest(
            self::REQUEST_METHOD_GET,
            sprintf(self::QR_CODE_ENDPOINT, $uriParameter),
        );

        try {
            $response = $this->guzzleClient->send($request);
        } catch (GuzzleException $exception) {
            throw QrCodeException::createByGuzzleException($exception);
        }

        return $response->getBody();
    }

    /**
     * @psalm-return non-empty-string
     */
    private function buildUriQuery(QrCodePreference $qrCodePreference): string
    {
        $queryParameter = sprintf(
            '%s/%s/%s/%d/%s',
            $qrCodePreference->getFormat(),
            $qrCodePreference->getBackgroundColor(),
            $qrCodePreference->getBarColor(),
            $qrCodePreference->getSize(),
            $qrCodePreference->getSpotifyUri(),
        );

        Assert::stringNotEmpty($queryParameter);

        return $queryParameter;
    }
}
