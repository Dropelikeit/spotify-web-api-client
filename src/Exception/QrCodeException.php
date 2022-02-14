<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Exception;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class QrCodeException extends RuntimeException
{
    public static function createByGuzzleException(GuzzleException $exception): self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
