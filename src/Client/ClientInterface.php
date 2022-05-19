<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Client;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 *
 * @description Acts as a client marker of this library
 */
interface ClientInterface
{
    public const REQUEST_METHOD_GET = 'GET';
    public const REQUEST_METHOD_POST = 'POST';
}
