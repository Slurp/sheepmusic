<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTvBundle\EventListener;

use BlackSheep\FanartTvBundle\Client\MusicClient;
use BlackSheep\FanartTvBundle\Model\FanartTvResponse;
use BlackSheep\MusicLibraryBundle\EventListener\AlbumEventListener;
use BlackSheep\MusicLibraryBundle\Events\AlbumEventInterface;
use BlackSheep\MusicLibraryBundle\Factory\ArtworkFactory;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepositoryInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

/**
 * AlbumEventSubscriber.
 */
class AlbumEventSubscriber implements AlbumEventListener
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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            AlbumEventInterface::ALBUM_EVENT_FETCHED => 'fetchedAlbum',
            AlbumEventInterface::ALBUM_EVENT_CREATED => 'createdAlbum',
            AlbumEventInterface::ALBUM_EVENT_UPDATED => 'updatedAlbum',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fetchedAlbum(AlbumEventInterface $event)
    {
        $this->updateArtWork($event);
    }

    /**
     * {@inheritdoc}
     */
    public function updatedAlbum(AlbumEventInterface $event)
    {
        $this->updateArtWork($event);
    }

    /**
     * {@inheritdoc}
     */
    public function createdAlbum(AlbumEventInterface $event)
    {
        $this->updateArtWork($event);
    }

    /**
     * @param AlbumEventInterface $albumEvent
     */
    protected function updateArtWork(AlbumEventInterface $albumEvent)
    {
        $album = $albumEvent->getAlbum();
        if (empty($album->getMusicBrainzId()) === false && empty($album->getCover()) === false) {
            try {
                $fanart = new FanartTvResponse(
                    json_decode(
                        $this->client->loadAlbum($album->getMusicBrainzId())->getBody()
                    )
                );
                $this->artworkFactory->addArtworkToAlbum($album, $fanart);
                $this->albumsRepository->save($album);
            } catch (ClientException $e) {
                error_log($e->getMessage());
            } catch (ConnectException $e) {
                error_log($e->getMessage());
            }
        }
    }
}
