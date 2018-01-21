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

use BlackSheep\FanartTvBundle\Updater\ArtistUpdater;
use BlackSheep\MusicLibraryBundle\EventListener\ArtistEventListener;
use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;

/**
 * ArtistEventSubscriber.
 */
class ArtistEventSubscriber implements ArtistEventListener
{
    /**
     * @var ArtistUpdater
     */
    private $artistUpdater;

    /**
     * @param ArtistUpdater $artistUpdater
     */
    public function __construct(ArtistUpdater $artistUpdater)
    {
        $this->artistUpdater = $artistUpdater;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            ArtistEventInterface::ARTIST_EVENT_FETCHED => 'fetchedArtist',
            ArtistEventInterface::ARTIST_EVENT_CREATED => 'createdArtist',
            ArtistEventInterface::ARTIST_EVENT_UPDATED => 'updatedArtist',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fetchedArtist(ArtistEventInterface $event)
    {
        $this->artistUpdater->updateArtWork($event->getArtist());
    }

    /**
     * {@inheritdoc}
     */
    public function updatedArtist(ArtistEventInterface $event)
    {
        $this->artistUpdater->updateArtWork($event->getArtist());
    }

    /**
     * {@inheritdoc}
     */
    public function createdArtist(ArtistEventInterface $event)
    {
        $this->artistUpdater->updateArtWork($event->getArtist());
    }
}
