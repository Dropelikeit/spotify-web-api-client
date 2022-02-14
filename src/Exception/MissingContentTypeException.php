<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Exception;

use InvalidArgumentException;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class MissingContentTypeException extends InvalidArgumentException
{
    public static function ifContentTypeJsonIsMissing(): self
    {
        return new self(
            'To parse a JSON object to a PHP object or array we need the content type "application/json".'
        );
    }
}
