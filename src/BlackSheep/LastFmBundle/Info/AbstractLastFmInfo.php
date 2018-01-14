<?php

namespace BlackSheep\LastFmBundle\Info;

use BlackSheep\LastFmBundle\Entity\LastFmUserEmbed;
use BlackSheep\MusicLibraryBundle\LastFm\LastFmInterface;
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
     * @var BaseApi
     */
    protected $api;

    /**
     * @var AuthApi
     */
    protected $auth;

    /**
     * @param string                $apiKey
     * @param string                $apiSecret
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct($apiKey, $apiSecret, TokenStorageInterface $tokenStorage)
    {
        $authArray = $this->setUserAuth($apiSecret, $tokenStorage);
        $authArray['apiKey'] = $apiKey;

        $this->auth = new AuthApi('setsession', $authArray);
    }

    /**
     * @param string                $apiSecret
     * @param TokenStorageInterface $tokenStorage
     *
     * @return array
     */
    protected function setUserAuth($apiSecret, TokenStorageInterface $tokenStorage)
    {
        $authArray = [];
        $user = $this->getUser($tokenStorage);
        if ($user instanceof LastFmUserEmbed &&
            $user->getLastFm()->hasLastFmConnected()
        ) {
            $authArray['apiSecret'] = $apiSecret;
            $authArray['token'] = $user->getLastFm()->getLastFmToken();
            $authArray['username'] = $user->getLastFm()->getLastFmUserName();
            $authArray['sessionKey'] = $user->getLastFm()->getLastFmKey();
            $authArray['subscriber'] = $user->getLastFm()->isLastFmSubscriber();
        }

        return $authArray;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     *
     * @return mixed|null
     */
    protected function getUser(TokenStorageInterface $tokenStorage)
    {
        if ($tokenStorage->getToken() !== null) {
            return $tokenStorage->getToken()->getUser();
        }

        return null;
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
                $lastFmInterface->setMusicBrainzId((string) $lastFmInfo->mbid);
            }

            return $lastFmInfo;
            // If something fails go quitely in to the night
        } catch (ConnectionException $connectionException) {
        } catch (ApiFailedException $apiFailedException) {
        }

        return null;
    }
}
