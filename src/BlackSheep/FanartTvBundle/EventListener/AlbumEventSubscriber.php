<?php

namespace BlackSheep\FanartTvBundle\EventListener;

use BlackSheep\FanartTvBundle\Client\MusicClient;
use BlackSheep\MusicLibraryBundle\EventListener\AlbumEventListener;
use BlackSheep\MusicLibraryBundle\Events\AlbumEventInterface;
use BlackSheep\MusicLibraryBundle\Factory\ArtworkFactory;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepositoryInterface;

/**
 * AlbumEventSubscriber
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
    private $logoFactory;

    /**
     * @param AlbumsRepositoryInterface $albumsRepository
     * @param MusicClient $client
     * @param ArtworkFactory $logoFactory
     */
    public function __construct(
        AlbumsRepositoryInterface $albumsRepository,
        MusicClient $client,
        ArtworkFactory $logoFactory
    ) {
        $this->albumsRepository = $albumsRepository;
        $this->client = $client;
        $this->logoFactory = $logoFactory;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            AlbumEventInterface::ALBUM_EVENT_FETCHED => "fetchedAlbum",
            AlbumEventInterface::ALBUM_EVENT_CREATED => "createdAlbum",
            AlbumEventInterface::ALBUM_EVENT_UPDATED => "updatedAlbum"
        ];
    }

    /**
     * @inheritDoc
     */
    public function fetchedAlbum(AlbumEventInterface $event)
    {
        // TODO: Implement fetchedAlbum() method.
    }

    /**
     * @inheritDoc
     */
    public function updatedAlbum(AlbumEventInterface $event)
    {
        // TODO: Implement updatedAlbum() method.
    }

    /**
     * @inheritDoc
     */
    public function createdAlbum(AlbumEventInterface $event)
    {
        // TODO: Implement createdAlbum() method.
    }
}
