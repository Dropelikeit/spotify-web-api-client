<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Exception;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class FetchTrackException extends RuntimeException
{
    public static function createByGuzzleClient(GuzzleException $exception): self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }

    public static function createByJsonException(JsonException $exception): self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
