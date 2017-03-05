<?php

namespace BlackSheep\LastFmBundle\Auth;

use BlackSheep\UserBundle\Entity\SheepUser;
use LastFmApi\Api\AuthApi;

/**
 * LastFm auth
 */
class LastFmAuth
{
    /**
     * @var AuthApi
     */
    protected $auth;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getToken()
    {
        $authArray = ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret];
        $auth = new AuthApi('gettoken', $authArray);
        return $auth->token->__toString();
    }

    public function getSession(SheepUser $user)
    {
        $authArray = ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret];
        $authArray['token'] = $user->getLastFmToken();
        $auth = new AuthApi('getsession', $authArray);
        $user->setLastFmKey($auth->sessionKey);
        $user->setLastFmUserName($auth->username);
        $user->setLastFmSubscriber($auth->subscriber);
    }

    /**
     * @return AuthApi
     */
    protected function getAuth()
    {
        return $this->auth;
    }
}
