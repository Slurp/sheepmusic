<?php

namespace BlackSheep\LastFmBundle\Auth;

use BlackSheep\LastFmBundle\Entity\LastFmUserEmbed;
use Doctrine\ORM\EntityManager;
use LastFmApi\Api\AuthApi;
use LastFmApi\Exception\ApiFailedException;

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
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param string $apiKey
     * @param string $apiSecret
     * @param EntityManager $entityManager
     */
    public function __construct($apiKey, $apiSecret, EntityManager $entityManager)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->entityManager = $entityManager;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param LastFmUserEmbed $user
     *
     * @return array
     */
    public function tokenForUser(LastFmUserEmbed $user)
    {
        $auth = new AuthApi(
            'gettoken',
            ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret]
        );
        $user->getLastFm()->setLastFmToken((string) $auth->token);
        $this->entityManager->flush($user);
        return [
            'token' => $user->getLastFm()->getLastFmToken(),
            'key' => $this->getApiKey()
        ];
    }

    /**
     * @param LastFmUserEmbed $user
     *
     * @throws ApiFailedException
     * @throws \Exception
     */
    public function sessionForUser(LastFmUserEmbed $user)
    {
        $authArray = ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret];
        $authArray['token'] = $user->getLastFm()->getLastFmToken();
        try {
            $auth = new AuthApi('getsession', $authArray);
            if ($auth === false) {
                $this->resetLastFmUser($user);
                throw new \Exception('NOOOOO!!! Something has failed us');
            }
            $user->getLastFm()->setLastFmKey($auth->sessionKey);
            $user->getLastFm()->setLastFmUserName($auth->username);
            $user->getLastFm()->setLastFmSubscriber($auth->subscriber);
            $this->entityManager->flush($user);
        } catch (ApiFailedException $exception) {
            $this->resetLastFmUser($user);
            throw $exception;
        }
    }

    /**
     * @param LastFmUserEmbed $user
     */
    private function resetLastFmUser(LastFmUserEmbed $user)
    {
        $user->getLastFm()->setLastFmKey('');
        $user->getLastFm()->setLastFmUserName('');
        $user->getLastFm()->setLastFmSubscriber(false);
        $user->getLastFm()->setLastFmToken('');
        $this->entityManager->flush($user);
    }
}
