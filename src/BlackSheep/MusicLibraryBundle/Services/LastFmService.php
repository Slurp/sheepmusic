<?php
namespace BlackSheep\MusicLibraryBundle\Services;

use LastFmApi\Api\AlbumApi;
use LastFmApi\Api\ArtistApi;
use LastFmApi\Api\AuthApi;

/**
 * Application name    sheepmusic
 * API key    749866a28418ccba11aa11b4ee11f857
 * Shared secret    ec5e8e5280699d3e5a8356f364a0bcc0
 * Registered to    Slurp
 */
class LastFmService
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var ArtistApi
     */
    private $artistApi;

    /**
     * @var AlbumApi
     */
    private $albumApi;

    /**
     */
    public function __construct()
    {
        $this->apiKey    = '749866a28418ccba11aa11b4ee11f857'; //required
        $auth            = new AuthApi('setsession', ['apiKey' => $this->apiKey]);
        $this->artistApi = new ArtistApi($auth);
        $this->albumApi  = new AlbumApi($auth);
    }

    /**
     * @param $artist
     * @return mixed
     */
    public function getArtistInfo($artist)
    {
        return $this->artistApi->getInfo(["artist" => $artist]);
    }

    /**
     * @param      $album
     * @param null $artist
     * @return array
     */
    public function getAlbumInfo($album, $artist = null)
    {
        return $this->albumApi->getInfo(["album" => $album, "artist" => $artist]);
    }

    /**
     * @param $artist
     * @return mixed
     */
    public function getBio($artist)
    {
        $artistInfo = $this->artistApi->getInfo(["artist" => $artist]);

        return $artistInfo['bio'];
    }
}