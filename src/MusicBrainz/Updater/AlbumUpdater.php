<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicBrainz\Updater;

use BlackSheep\MusicBrainz\Client\CoverartClient;
use BlackSheep\MusicBrainz\Client\ReleaseClient;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class AlbumUpdater.
 */
class AlbumUpdater
{
    /**
     * @var AlbumsRepository
     */
    protected $albumsRepository;

    /**
     * @var ReleaseClient
     */
    protected $client;

    /**
     * @var CoverartClient
     */
    protected $coverartClient;

    /**
     * @param AlbumsRepository $albumsRepository
     * @param ReleaseClient $client
     * @param CoverartClient $coverartClient
     */
    public function __construct(
        AlbumsRepository $albumsRepository,
        ReleaseClient $client,
        CoverartClient $coverartClient
    ) {
        $this->albumsRepository = $albumsRepository;
        $this->client = $client;
        $this->coverartClient = $coverartClient;
    }

    /**
     * @param AlbumInterface $album
     */
    public function updateReleaseGroup(AlbumInterface $album)
    {
        if (empty($album->getMusicBrainzId()) === false && empty($album->getMusicBrainzReleaseGroupId())) {
            try {
                $musicBrainzInfo = json_decode(
                    $this->client->loadRelease($album->getMusicBrainzId())->getBody()
                );
                $album->setMusicBrainzReleaseGroupId($musicBrainzInfo->{'release-group'}->id);
                $this->albumsRepository->save($album);
            } catch (ClientException $e) {
                error_log($e->getMessage());
            } catch (ConnectException $e) {
                error_log($e->getMessage());
            }
        }
    }

    /**
     * @param AlbumInterface $album
     */
    public function getCover(AlbumInterface $album)
    {
        if (empty($album->getMusicBrainzId()) === false && empty($album->getCover())) {
            try {

                $musicBrainzInfo = json_decode(
                    $this->coverartClient->getCover($album->getMusicBrainzId())->getBody()->getContents()
                );
                if (property_exists($musicBrainzInfo, 'images')) {
                    $album->setCover($musicBrainzInfo->images[0]->image);
                    $this->albumsRepository->update($album);
                }
            } catch (ClientException $e) {
                error_log($e->getMessage());
            } catch (ConnectException $e) {
                error_log($e->getMessage());
            } catch (GuzzleException $e) {
                error_log($e->getMessage());
            }
        }
    }
}
