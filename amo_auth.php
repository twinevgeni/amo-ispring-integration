<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php";

use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessToken;
use amoispring\helpers\common\LoggerHelper;

$logger = LoggerHelper::getLogger("amo_auth.php");
$logger->info('amo_auth.php call');

$apiClient = new AmoCRMApiClient(AMO_CLIENT_ID, AMO_SECRTET, AMO_REDIRECT_URL);

define('TOKEN_FILE', AMO_TOKEN_FILE);

/**
 * @param array $accessToken
 */
function saveToken($accessToken)
{
    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        $data = [
            'accessToken' => $accessToken['accessToken'],
            'expires' => $accessToken['expires'],
            'refreshToken' => $accessToken['refreshToken'],
            'baseDomain' => $accessToken['baseDomain'],
        ];

        file_put_contents(TOKEN_FILE, json_encode($data));
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

/**
 * @return AccessToken
 */
function getToken()
{
    if (!file_exists(TOKEN_FILE)) {
        exit('Access token file not found');
    }

    $accessToken = json_decode(file_get_contents(TOKEN_FILE), true);

    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        return new AccessToken([
            'access_token' => $accessToken['accessToken'],
            'refresh_token' => $accessToken['refreshToken'],
            'expires' => $accessToken['expires'],
            'baseDomain' => $accessToken['baseDomain'],
        ]);
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

$apiClient->getOAuthClient()->setBaseDomain(AMO_BASE_DOMAIN);
$accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode(AMO_CODE);

var_dump($accessToken);

saveToken([
    'accessToken' => $accessToken->getToken(),
    'refreshToken' => $accessToken->getRefreshToken(),
    'expires' => $accessToken->getExpires(),
    'baseDomain' => AMO_BASE_DOMAIN
]);