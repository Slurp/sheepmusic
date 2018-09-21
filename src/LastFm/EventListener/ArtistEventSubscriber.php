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

use BlackSheep\LastFm\Updater\ArtistUpdater;
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
    protected $artistUpdater;

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
            ArtistEventInterface::ARTIST_EVENT_UPDATED => 'addSimilar',
        ];
    }

    /**
     * @param ArtistEventInterface $artistEvent
     */
    public function addSimilar(ArtistEventInterface $artistEvent)
    {
        $this->artistUpdater->addSimilar($artistEvent->getArtist());
    }
}
