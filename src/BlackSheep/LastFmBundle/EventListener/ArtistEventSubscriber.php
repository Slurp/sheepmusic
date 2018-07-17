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

use BlackSheep\LastFmBundle\Updater\ArtistUpdater;
use BlackSheep\MusicLibraryBundle\Entity\SimilarArtist\SimilarArtistEntity;
use BlackSheep\MusicLibraryBundle\EventListener\ArtistEventListener;
use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;

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
