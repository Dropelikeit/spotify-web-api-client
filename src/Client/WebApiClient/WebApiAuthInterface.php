<?php

declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client\WebApiClient;

use InvalidArgumentException;
use MarcelStrahl\SpotifyWebApiClient\Client\ClientInterface;
use MarcelStrahl\SpotifyWebApiClient\Exception\WebApiAuthException;
use MarcelStrahl\SpotifyWebApiClient\Model\AccessToken;
use MarcelStrahl\SpotifyWebApiClient\Model\Credentials;

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
