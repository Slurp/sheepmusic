<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\EventListener;

use BlackSheep\LastFm\Info\LastFmAlbumInfo;
use BlackSheep\MusicLibrary\EventListener\AlbumEventListener;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;

/**
 * AlbumEventSubscriber.
 */
class AlbumEventSubscriber implements AlbumEventListener
{
    /**
     * @var AlbumsRepository
     */
    protected $albumsRepository;

    /**
     * @var LastFmAlbumInfo
     */
    protected $client;

    /**
     * @param AlbumsRepository $albumsRepository
     * @param LastFmAlbumInfo           $client
     */
    public function __construct(
        AlbumsRepository $albumsRepository,
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
