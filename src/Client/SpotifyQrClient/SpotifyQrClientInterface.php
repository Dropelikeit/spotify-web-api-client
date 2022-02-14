<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client\SpotifyQrClient;

use MarcelStrahl\SpotifyWebApiClient\Client\ClientInterface;
use MarcelStrahl\SpotifyWebApiClient\Exception\QrCodeException;
use MarcelStrahl\SpotifyWebApiClient\Model\SpotifyQrClient\QrCodePreference;
use Psr\Http\Message\StreamInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
interface SpotifyQrClientInterface extends ClientInterface
{
    /**
     * @throws QrCodeException
     */
    public function fetchQrCode(QrCodePreference $qrCodePreference): StreamInterface;
}
