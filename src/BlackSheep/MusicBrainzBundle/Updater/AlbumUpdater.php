<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicBrainzBundle\Updater;

use BlackSheep\MusicBrainzBundle\Client\ReleaseClient;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepositoryInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

/**
 * Class AlbumUpdater.
 */
class AlbumUpdater
{
    /**
     * @var AlbumsRepositoryInterface
     */
    protected $albumsRepository;

    /**
     * @var ReleaseClient
     */
    protected $client;

    /**
     * @param AlbumsRepositoryInterface $albumsRepository
     * @param ReleaseClient             $client
     */
    public function __construct(
        AlbumsRepositoryInterface $albumsRepository,
        ReleaseClient $client
    ) {
        $this->albumsRepository = $albumsRepository;
        $this->client = $client;
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
}
