<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFmBundle\EventListener;

use BlackSheep\LastFmBundle\Info\LastFmAlbumInfo;
use BlackSheep\MusicLibraryBundle\EventListener\AlbumEventListener;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepositoryInterface;

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
     * @var LastFmAlbumInfo
     */
    protected $client;

    /**
     * @param AlbumsRepositoryInterface $albumsRepository
     * @param LastFmAlbumInfo           $client
     */
    public function __construct(
        AlbumsRepositoryInterface $albumsRepository,
        LastFmAlbumInfo $client
    ) {
        $this->albumsRepository = $albumsRepository;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
        ];
    }
}
