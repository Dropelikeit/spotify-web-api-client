<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client;

use MarcelStrahl\SpotifyWebApiClient\Model\Track;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface WebApiClientInterface extends ClientInterface
{
    /**
     * @psalm-param non-empty-string $trackId
     */
    public function getTrackById(string $trackId): Track;
}
