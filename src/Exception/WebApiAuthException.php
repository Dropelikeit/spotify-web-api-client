<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Exception;

use Exception;
use Throwable;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class WebApiAuthException extends Exception
{
    public static function createFromGuzzleException(
        string $message,
        int $code,
        ?Throwable $previousException = null
    ): self {
        return new self($message, $code, $previousException);
    }

    public static function createFromJsonException(Throwable $exception): self
    {
        return new self('Unexpected response content type.', 500, $exception);
    }
}
