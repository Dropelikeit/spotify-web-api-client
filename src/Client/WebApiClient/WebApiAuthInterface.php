<?php

declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Client\WebApiClient;

use InvalidArgumentException;
use MarcelStrahl\SpotifyApiClient\Client\ClientInterface;
use MarcelStrahl\SpotifyApiClient\Exception\WebApiAuthException;
use MarcelStrahl\SpotifyApiClient\Model\AccessToken;
use MarcelStrahl\SpotifyApiClient\Model\Credentials;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface WebApiAuthInterface extends ClientInterface
{
    /**
     * @throws WebApiAuthException
     * @throws InvalidArgumentException
     */
    public function loadAccessToken(Credentials $credentials): AccessToken;
}
