<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\EventListener;

use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface ArtistEventListener.
 */
interface ArtistEventListener extends EventSubscriberInterface
{
    /**
     * @param ArtistEventInterface $event;
     */
    public function fetchedArtist(ArtistEventInterface $event);

    /**
     * @param ArtistEventInterface $event;
     */
    public function updatedArtist(ArtistEventInterface $event);

    /**
     * @param ArtistEventInterface $event;
     */
    public function createdArtist(ArtistEventInterface $event);
}
