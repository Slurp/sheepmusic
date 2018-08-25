<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTv\Updater;

use BlackSheep\FanartTv\Client\MusicClient;
use BlackSheep\FanartTv\Model\FanartTvResponse;
use BlackSheep\MusicLibrary\Factory\ArtworkFactory;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Repository\AlbumsRepositoryInterface;
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
     * @var MusicClient
     */
    protected $client;

    /**
     * @var ArtworkFactory
     */
    private $artworkFactory;

    /**
     * @param AlbumsRepositoryInterface $albumsRepository
     * @param MusicClient               $client
     * @param ArtworkFactory            $logoFactory
     */
    public function __construct(
        AlbumsRepositoryInterface $albumsRepository,
        MusicClient $client,
        ArtworkFactory $logoFactory
    ) {
        $this->albumsRepository = $albumsRepository;
        $this->client = $client;
        $this->artworkFactory = $logoFactory;
    }

    /**
     * @param AlbumInterface $album
     */
    public function updateArtWork(AlbumInterface $album)
    {
        if (empty($album->getMusicBrainzId()) === false && empty($album->getCover()) === false) {
            try {
                $fanart = new FanartTvResponse(
                    json_decode(
                        $this->client->loadAlbum($album->getMusicBrainzId())->getBody()
                    )
                );
                $this->artworkFactory->addArtworkToAlbum($album, $fanart);
                $this->albumsRepository->save($album);
                unset($fanart);
            } catch (ClientException $e) {
                error_log($e->getMessage());
            } catch (ConnectException $e) {
                error_log($e->getMessage());
            }
        }
    }
}
