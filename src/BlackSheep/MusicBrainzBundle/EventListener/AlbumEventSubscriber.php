<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicBrainzBundle\EventListener;

use BlackSheep\MusicBrainzBundle\Updater\AlbumUpdater;
use BlackSheep\MusicLibraryBundle\EventListener\AlbumEventListener;
use BlackSheep\MusicLibraryBundle\Events\AlbumEventInterface;

/**
 * AlbumEventSubscriber.
 */
class AlbumEventSubscriber implements AlbumEventListener
{
    /**
     * @var AlbumUpdater
     */
    private $albumUpdater;

    /**
     * @param AlbumUpdater $albumUpdater
     */
    public function __construct(AlbumUpdater $albumUpdater)
    {
        $this->albumUpdater = $albumUpdater;
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
    public function createdAlbum(AlbumEventInterface $event)
    {
        $this->albumUpdater->updateReleaseGroup($event->getAlbum());
    }

    /**
     * {@inheritdoc}
     */
    public function fetchedAlbum(AlbumEventInterface $event)
    {
        $this->albumUpdater->updateReleaseGroup($event->getAlbum());
    }

    /**
     * {@inheritdoc}
     */
    public function updatedAlbum(AlbumEventInterface $event)
    {
        $this->albumUpdater->updateReleaseGroup($event->getAlbum());
    }
}
