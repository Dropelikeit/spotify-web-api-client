<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Exception;

use InvalidArgumentException;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class MissingHeaderContentException extends InvalidArgumentException
{
    /**
     * @psalm-param non-empty-string $header
     */
    public static function create(string $header): self
    {
        return new self('Required Header "%s" is Missing');
    }
}
