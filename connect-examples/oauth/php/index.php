<?php
/*
|--------------------------------------------------------------------------
| OAuth Authorization Link Example
|--------------------------------------------------------------------------
|
| This file simply serves the link that merchants click to authorize your
| application. When authorization completes, a notification is sent to
| your redirect URL, which should be handled in callback.php.
*/

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$prodEnv = getenv('ENVIRONMENT') === 'production';
$appId = $prodEnv ? getenv('PRODUCTION_APP_ID') : getenv('SANDBOX_APP_ID');
$baseUrl = $prodEnv
    ? 'https://connect.squareupstaging.com'
    : 'https://connect.squareupsandbox.com';

// Show a link to the user to start the OAuth flow
echo sprintf('<a href="%s/oauth2/authorize?client_id=%s">Click here</a> to authorize the application.',
    $baseUrl,
    $appId,
);
