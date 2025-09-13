<?php

namespace jewellclub\helpers\amo;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use jewellclub\common\BaseComponent;
use jewellclub\helpers\common\StringHelper;

/**
 * AmoApiHelper
 */
class AmoApiHelper extends BaseComponent
{
    /**
     * @var AmoApiHelper|null
     */
    private static ?AmoApiHelper $instance = null;

    /**
     * @return AmoApiHelper
     */
    public static function getInstance(): AmoApiHelper
    {
        if (self::$instance === null) {
            self::$instance = new AmoApiHelper();
        }

        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct("AmoApiHelper");
    }

    /**
     * @param AccessTokenInterface $accessToken
     * @return void
     */
    public function saveToken(AccessTokenInterface $accessToken)
    {
        $this->logger->info("saveToken: " . json_encode($accessToken));
        $this->saveTokenAsArray([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires(),
        ]);
    }

    /**
     * @param array $accessToken
     */
    public function saveTokenAsArray(array $accessToken)
    {
        $this->logger->info("saveTokenAsArray: " . json_encode($accessToken));
        if (
            isset($accessToken['accessToken'])
            && isset($accessToken['refreshToken'])
            && isset($accessToken['expires'])
        ) {
            file_put_contents(AMO_TOKEN_FILE, json_encode($accessToken));
        } else {
            $this->logger->error("saveTokenAsArray error");
        }
    }

    /**
     * @return LongLivedAccessToken|null
     */
    private function getLongToken(): ?LongLivedAccessToken
    {
        $this->logger->info("getLongToken");
        if (StringHelper::isNotEmpty(AMO_LONG_TOKEN)) {
            return new LongLivedAccessToken(AMO_LONG_TOKEN);
        }

        return null;
    }

    /**
     * @return AccessToken|null
     */
    public function getToken(): ?AccessToken
    {
        $this->logger->info("getToken");
        $longToken = $this->getLongToken();
        if ($longToken !== null) {
            return $longToken;
        }

        if (!file_exists(AMO_TOKEN_FILE)) {
            $this->logger->error("getToken error | file not exists: " . AMO_TOKEN_FILE);
            return null;
        }

        $accessTokenData = file_get_contents(AMO_TOKEN_FILE);
        $accessToken = json_decode($accessTokenData, true);
        $this->logger->info("getToken | token loaded " . json_encode($accessToken));

        if (
            isset($accessToken)
            && isset($accessToken['accessToken'])
            && isset($accessToken['refreshToken'])
            && isset($accessToken['expires'])
        ) {
            return new AccessToken([
                'access_token' => $accessToken['accessToken'],
                'refresh_token' => $accessToken['refreshToken'],
                'expires' => $accessToken['expires'],
                'baseDomain' => AMO_BASE_DOMAIN
            ]);
        }

        return null;
    }

    /**
     * Получить Api Client с токеном
     * @return AmoCRMApiClient|null
     */
    public function getApiClient(): ?AmoCRMApiClient
    {
        $this->logger->info("getApiClient");
        $apiClient = new AmoCRMApiClient(AMO_CLIENT_ID, AMO_SECRTET, AMO_REDIRECT_URL);
        $accessToken = $this->getToken();

        if ($accessToken === null) {
            $this->logger->error("getApiClient | token is null");
            return null;
        }

        if ($accessToken->hasExpired()) {
            $this->logger->info("token is expired | refreshing");
            try {
                $apiClient->getOAuthClient()->setBaseDomain(AMO_BASE_DOMAIN);
                $accessToken = $apiClient->getOAuthClient()->getAccessTokenByRefreshToken($accessToken);
                $this->logger->info("token refresh done");
                $this->saveToken($accessToken);
            } catch (\Exception $e) {
                $this->logger->error("getApiClient | refresh token error: " . $e->getMessage());
            }
        }

        $apiClient->getOAuthClient()->setBaseDomain(AMO_BASE_DOMAIN);
        $apiClient->setAccessToken($accessToken);
        return $apiClient;
    }

}