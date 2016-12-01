<?php
namespace BlackSheep\MusicLibraryBundle\LastFm;

use LastFmApi\Api\AuthApi;
use LastFmApi\Api\BaseApi;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;

/**
 * Application name    sheepmusic
 * API key    749866a28418ccba11aa11b4ee11f857
 * Shared secret    ec5e8e5280699d3e5a8356f364a0bcc0
 * Registered to    Slurp
 */
abstract class AbstractLastFmInfo
{
    /**
     * @var AuthApi
     */
    protected $auth;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey = '749866a28418ccba11aa11b4ee11f857')
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
     * @inheritDoc
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
