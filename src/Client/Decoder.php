<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client;

use function in_array;
use function json_decode;
use JsonException;
use MarcelStrahl\SpotifyWebApiClient\Exception\MissingContentTypeException;
use MarcelStrahl\SpotifyWebApiClient\Exception\MissingHeaderContentException;
use Psr\Http\Message\ResponseInterface;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
abstract class Decoder
{
    private const HEADER_CONTENT_TYPE = 'Content-Type';
    private const CONTENT_TYPE_JSON = 'application/json';

    /**
     * @throws MissingHeaderContentException
     * @throws MissingContentTypeException
     * @throws JsonException
     * @return array<string, mixed>
     */
    public function decodePayloadAsAssociateArray(ResponseInterface $response): array
    {
        $this->checkHeader($response);

        $content = json_decode(
            (string) $response->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        Assert::isArray($content);
        Assert::isMap($content);

        return $content;
    }

    /**
     * @throws MissingHeaderContentException
     * @throws MissingContentTypeException
     * @throws JsonException
     * @psalm-template T
     * @psalm-param class-string<T> $stub
     * @psalm-return T
     */
    public function decodePayload(ResponseInterface $response, string $stub)
    {
        $this->checkHeader($response);

        /** @psalm-var T $content */
        $content = json_decode(
            (string) $response->getBody(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );

        return $content;
    }

    /**
     * @throws MissingHeaderContentException
     * @throws MissingContentTypeException
     */
    private function checkHeader(ResponseInterface $response): void
    {
        if (!$response->hasHeader(self::HEADER_CONTENT_TYPE)) {
            throw MissingHeaderContentException::create(self::HEADER_CONTENT_TYPE);
        }

        $contentType = $response->getHeader(self::HEADER_CONTENT_TYPE);
        if (!in_array(self::CONTENT_TYPE_JSON, $contentType, true)) {
            throw MissingContentTypeException::ifContentTypeJsonIsMissing();
        }
    }
}
