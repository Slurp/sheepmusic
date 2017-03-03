<?php

namespace BlackSheep\MusicLibraryBundle\LastFm;

use LastFmApi\Api\AuthApi;
use LastFmApi\Api\BaseApi;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;

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
     */
    public function __construct($apiKey)
    {
        $this->auth = new AuthApi('setsession', ['apiKey' => $apiKey]);
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
