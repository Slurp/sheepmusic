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

use BlackSheep\FanartTv\Updater\ArtistUpdater;
use BlackSheep\MusicLibrary\EventListener\ArtistEventListener;
use BlackSheep\MusicLibrary\Events\ArtistEventInterface;

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
            ArtistEventInterface::ARTIST_EVENT_UPDATED => 'updatedArtist',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function updatedArtist(ArtistEventInterface $event)
    {
        $this->artistUpdater->updateArtWork($event->getArtist());
    }
}
