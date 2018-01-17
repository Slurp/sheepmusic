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

use BlackSheep\MusicLibraryBundle\Events\AlbumEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface AlbumEventListener.
 */
interface AlbumEventListener extends EventSubscriberInterface
{
    /**
     * @param AlbumEventInterface $event;
     */
    public function fetchedAlbum(AlbumEventInterface $event);

    /**
     * @param AlbumEventInterface $event;
     */
    public function updatedAlbum(AlbumEventInterface $event);

    /**
     * @param AlbumEventInterface $event;
     */
    public function createdAlbum(AlbumEventInterface $event);
}
