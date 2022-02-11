<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Client;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface AuthenticationApiClientInterface
{
    public function fetchAccessToken(): void;
}
