<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Info;

use BlackSheep\LastFm\Entity\LastFmUserEmbed;
use BlackSheep\MusicLibrary\LastFm\LastFmInterface;
use LastFmApi\Api\AuthApi;
use LastFmApi\Api\BaseApi;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
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
     * @var bool
     */
    protected $isUserAuth = false;

    /**
     * @param ContainerBagInterface $containerBag
     * @param TokenStorageInterface $tokenStorage
     *
     * @throws \LastFmApi\Exception\InvalidArgumentException
     */
    public function __construct(ContainerBagInterface $containerBag, TokenStorageInterface $tokenStorage)
    {
        $authArray = $this->setUserAuth(
            $containerBag->get('black_sheep_music_library.last_fm_api_secret'),
            $tokenStorage
        );
        $authArray['apiKey'] = $containerBag->get('black_sheep_music_library.last_fm_api_key');

        $this->auth = new AuthApi('setsession', $authArray);
    }

    /**
     * @param string $apiSecret
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
            $this->isUserAuth = true;
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
            if ($lastFmInterface->getMusicBrainzId() === null && empty((string) $lastFmInfo->mbid) === false) {
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
