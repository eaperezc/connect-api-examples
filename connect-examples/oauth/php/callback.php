<?php
/*
|--------------------------------------------------------------------------
| OAuth Callback Example
|--------------------------------------------------------------------------
|
| Here we will show the bare-bones implementation of the Square Connect
| OAuth flow. This will be called after the user clicked on the previous
| link, signs in to Square and submits the Permissions form. Finnally,
| Square sends a request to your application's Redirect URL (configured)
| on your Square App settings at https://developers.squareup.com/apps.
|
| Here we will see how we can get an authorization token so we can
| make API request in behalf of this merchant.
*/

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Http\ApiResponse;
use Square\Models\ObtainTokenRequest;
use Square\Models\ObtainTokenResponse;
use Square\SquareClient;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$prodEnv = getenv('ENVIRONMENT') === 'production';

$appId = $prodEnv
    ? getenv('PRODUCTION_APP_ID')
    : getenv('SANDBOX_APP_ID');

$appAccessToken = $prodEnv
    ? getenv('PRODUCTION_ACCESS_TOKEN')
    : getenv('SANDBOX_ACCESS_TOKEN');

$appSecret = $prodEnv
    ? getenv('PRODUCTION_APP_SECRET')
    : getenv('SANDBOX_APP_SECRET');

$client = new SquareClient([
    'accessToken' => $appAccessToken,
    'environment' => Environment::CUSTOM,
    'baseUrl' => 'https://connect.squareupstaging.com',
]);

$oAuthApi = $client->getOauthApi();

$authorizationCode = $_GET['code'];
if (!$authorizationCode) {
    echo 'Authorization failed!';
    exit;
}

// Prepare our request object
$request = new ObtainTokenRequest($appId, $appSecret, 'authorization_code');
$request->setCode($authorizationCode);

try {
    /**
     * Send the request to the server
     * @var ApiResponse $response
     */
    $response = $oAuthApi->obtainToken($request);

    // If there was an error with the request we will
    // print them to the browser screen here
    if ($response->isError()) {
        echo 'Api response has Errors';
        $errors = $response->getErrors();
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>❌ ' . $error->getDetail() . '</li>';
        }
        echo '</ul>';
        exit;
    }

    /**
     * This response will have our new access token
     * @var ObtainTokenResponse
     */
    $obtainTokenResponse = $response->getBody();
    $accessToken = $obtainTokenResponse->getAccessToken();

    if ($accessToken != null) {
        // Here, instead of printing the access token, your application server
        // should store it securely and use it in subsequent requests to the
        // Connect API on behalf of the merchant.
        echo '<p>Access token: ' . $accessToken . '</p><br>';
        echo '<h3>🙌 Authorization succeeded!</h3>';
    } else {
        // The response from the Obtain Token endpoint did
        // not include an access token. Something went wrong.
        echo 'Code exchange failed!';
    }
} catch (ApiException $e) {
    // This will be thrown if the API completely failed
    echo $e->getMessage();
}
