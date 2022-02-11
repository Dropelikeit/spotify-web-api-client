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
use MarcelStrahl\SpotifyApiClient\Client\WebApiClient;
use MarcelStrahl\SpotifyApiClient\Facade\WebApiAuthFacade;
use MarcelStrahl\SpotifyApiClient\Facade\WebApiClientFacade;
use MarcelStrahl\SpotifyApiClient\Model\Credentials;
use Webmozart\Assert\Assert;

require __DIR__. '/../vendor/autoload.php';

$facade = new WebApiAuthFacade(new RequestFactory());

$authenticationClient = $facade->buildInstance();

$accessToken = $authenticationClient->loadAccessToken(Credentials::create([
    'clientId' => 'cd6dad42a04e48869014c2847c738d2e',
    'clientSecret' => 'fd366c8acf3042c29f0937e66c3cada3',
]));

$apiFacade = new WebApiClientFacade(new RequestFactory());
$webApiClient = $apiFacade->buildInstance($accessToken);
Assert::isInstanceOf($webApiClient, WebApiClient::class);

$track = $webApiClient->getTrackById('4xkOaSrkexMciUUogZKVTS');

var_dump($track);
```

## Contribute

This library is under active development.
If you encounter bugs, have suggestions for improvements or enhancements, or want to implement, you can open [an issue](/issues).

If you want to work on the documentation or on a reported bug or suggested feature, you can do so by forking the project and later submitting a pull request on Github.
If you need help at any time, don't hesitate to ask for assistance.
