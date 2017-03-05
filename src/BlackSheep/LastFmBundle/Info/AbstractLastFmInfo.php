<?php

namespace BlackSheep\LastFmBundle\Info;

use BlackSheep\MusicLibraryBundle\LastFm\LastFmInterface;
use BlackSheep\UserBundle\Entity\SheepUser;
use LastFmApi\Api\AuthApi;
use LastFmApi\Api\BaseApi;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * LastFm API wrapper for the music.
 */
abstract class AbstractLastFmInfo implements LastFmInfo
{
    /**
     * @var AuthApi
     */
    protected $auth;

    /**
     * @param string $apiKey
     * @param string $apiSecret
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct($apiKey, $apiSecret, TokenStorageInterface $tokenStorage)
    {
        /** @var SheepUser $user */
        $user = $tokenStorage->getToken()->getUser();
        $authArray = ['apiKey' => $apiKey, 'apiSecret' => $apiSecret];
        $authArray['token'] = $user->getLastFmToken();
        $authArray['username'] = $user->getLastFmUserName();
        $authArray['sessionKey'] = $user->getLastFmKey();
        $authArray['subscriber'] = $user->getLastFmSubscriber();
        $this->auth = new AuthApi('setsession', $authArray);
    }

    /**
     * @return AuthApi
     */
    protected function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return BaseApi
     */
    abstract protected function getApi();

    /**
     * {@inheritdoc}
     */
    public function getInfo(LastFmInterface $lastFmInterface)
    {
        try {
            $lastFmInfo = $this->getApi()->getInfo($lastFmInterface->getLastFmInfoQuery());
            if ($lastFmInterface->getMusicBrainzId() !== null) {
                $lastFmInterface->setMusicBrainzId($lastFmInfo['mbid']);
            }

            return $lastFmInfo;
        } catch (ConnectionException $connectionException) {
        } catch (ApiFailedException $apiFailedException) {
        }

        return null;
    }
}
