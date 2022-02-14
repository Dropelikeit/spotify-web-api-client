# Spotify API Client

### Important note
This package is currently in development of the alpha version and provides only the simple backend login (Client Credentials Flow: https://developer.spotify.com/documentation/general/guides/authorization/client-credentials/) and the fetching of a track via Track-ID.

### Outlook of the next steps
In the future, we want to provide authentication across all 3 authorizations, as well as a client that can communicate with all endpoints of Spotify's web app.

Usage:

```php 
<?php
declare(strict_types=1);

use Laminas\Diactoros\RequestFactory;
use MarcelStrahl\SpotifyWebApiClient\Client\WebApiClient;
use MarcelStrahl\SpotifyWebApiClient\Facade\SpotifyQrClientFacade;
use MarcelStrahl\SpotifyWebApiClient\Facade\WebApiAuthFacade;
use MarcelStrahl\SpotifyWebApiClient\Facade\WebApiClientFacade;
use MarcelStrahl\SpotifyWebApiClient\Model\Credentials;
use MarcelStrahl\SpotifyWebApiClient\Model\SpotifyQrClient\QrCodePreference;
use Webmozart\Assert\Assert;

require __DIR__ . '/../vendor/autoload.php';

$requestFactory = new RequestFactory();

$facade = new WebApiAuthFacade($requestFactory);

$authenticationClient = $facade->buildInstance();

$accessToken = $authenticationClient->loadAccessToken(Credentials::create([
    'clientId' => '',
    'clientSecret' => '',
]));

$apiFacade = new WebApiClientFacade($requestFactory);
$webApiClient = $apiFacade->buildInstance($accessToken);
Assert::isInstanceOf($webApiClient, WebApiClient::class);

$track = $webApiClient->getTrackById('4xkOaSrkexMciUUogZKVTS');

$qrClientFacade = new SpotifyQrClientFacade($requestFactory);
$qrClient = $qrClientFacade->buildInstance();

$qrClient->fetchQrCode(QrCodePreference::create(
    '000000',
    QrCodePreference::BAR_COLOR_WHITE,
    640,
    QrCodePreference::FORMAT_JPEG,
    $track->getUri(),
));

var_dump($track, $file);
```

## Contribute

This library is under active development.
If you encounter bugs, have suggestions for improvements or enhancements, or want to implement, you can open [an issue](/issues).

If you want to work on the documentation or on a reported bug or suggested feature, you can do so by forking the project and later submitting a pull request on Github.
If you need help at any time, don't hesitate to ask for assistance.
