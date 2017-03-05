<?php

namespace BlackSheep\LastFmBundle\Auth;

use BlackSheep\UserBundle\Entity\SheepUser;
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
     * @param SheepUser $user
     *
     * @return array
     */
    public function tokenForUser(SheepUser $user)
    {
        $auth = new AuthApi(
            'gettoken',
            ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret]
        );
        $user->setLastFmToken($auth->token->__toString());
        $this->entityManager->flush($user);

        return [
            'token' => $user->getLastFmToken(),
            'key' => $this->getApiKey()
        ];
    }

    /**
     * @param SheepUser $user
     *
     * @throws ApiFailedException
     * @throws \Exception
     */
    public function sessionForUser(SheepUser $user)
    {
        $authArray = ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret];
        $authArray['token'] = $user->getLastFmToken();
        try {
            $auth = new AuthApi('getsession', $authArray);
            if ($auth === false) {
                $this->resetLastFmUser($user);
                throw new \Exception('NOOOOO!!! Something has failed us');
            }
            $user->setLastFmKey($auth->sessionKey);
            $user->setLastFmUserName($auth->username);
            $user->setLastFmSubscriber($auth->subscriber);
            $this->entityManager->flush($user);
        } catch (ApiFailedException $exception) {
            $this->resetLastFmUser($user);
            throw $exception;
        }
    }

    /**
     * @param SheepUser $user
     */
    private function resetLastFmUser(SheepUser $user)
    {
        $user->setLastFmKey('');
        $user->setLastFmUserName('');
        $user->setLastFmSubscriber('');
        $user->setLastFmToken('');
        $this->entityManager->flush($user);
    }
}
