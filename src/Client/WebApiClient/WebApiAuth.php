<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client\WebApiClient;

use function base64_encode;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use function json_decode;
use JsonException;
use MarcelStrahl\SpotifyWebApiClient\Exception\WebApiAuthException;
use MarcelStrahl\SpotifyWebApiClient\Model\AccessToken;
use MarcelStrahl\SpotifyWebApiClient\Model\Credentials;
use Psr\Http\Message\RequestFactoryInterface;
use function sprintf;
use stdClass;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiAuth implements WebApiAuthInterface
{
    private const HTTP_METHOD_POST = 'POST';
    private const FETCH_ACCESS_TOKEN = '/api/token';

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
     * @throws WebApiAuthException
     * @throws InvalidArgumentException
     */
    public function loadAccessToken(Credentials $credentials): AccessToken
    {
        $request = $this->requestFactory->createRequest(self::HTTP_METHOD_POST, self::FETCH_ACCESS_TOKEN)
            ->withHeader('Authorization', sprintf('Basic %s', $this->buildBearer($credentials)))
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');

        try {
            $response = $this->guzzleClient->send($request, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
        } catch (GuzzleException $exception) {
            throw WebApiAuthException::createFromGuzzleException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        $content = (string) $response->getBody();
        Assert::stringNotEmpty($content);

        try {
            $responseData = json_decode(
                $content,
                false,
                512,
                JSON_THROW_ON_ERROR
            );

            Assert::object($responseData);
            Assert::isInstanceOf($responseData, stdClass::class);
        } catch (JsonException $exception) {
            throw WebApiAuthException::createFromJsonException($exception);
        }

        return AccessToken::create($responseData);
    }

    private function buildBearer(Credentials $credentials): string
    {
        return base64_encode(sprintf(
            '%s:%s',
            $credentials->getClientId(),
            $credentials->getClientSecret()
        ));
    }
}
