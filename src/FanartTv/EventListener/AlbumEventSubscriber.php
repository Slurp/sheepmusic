<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTv\EventListener;

use BlackSheep\FanartTv\Updater\AlbumUpdater;
use BlackSheep\MusicLibrary\EventListener\AlbumEventListener;
use BlackSheep\MusicLibrary\Events\AlbumEventInterface;

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
     * AlbumEventSubscriber constructor.
     *
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
            // AlbumEventInterface::ALBUM_EVENT_UPDATED => 'updatedAlbum', do it by artist for the momement
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function updatedAlbum(AlbumEventInterface $event)
    {
        $this->albumUpdater->updateArtWork($event->getAlbum());
    }
}
