<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Stub;

use stdClass;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class AccessTokenResponse extends stdClass
{
    public string $access_token;

    public string $token_type;

    public int $expires_in;
}
