<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\EventListener;

use BlackSheep\MusicLibrary\Factory\PlaylistFactory;
use BlackSheep\MusicLibrary\Repository\PlaylistRepository;
use BlackSheep\MusicScanner\Event\ImportEventInterface;

/**
 * ImportEventSubscriber.
 */
class ImportEventSubscriber implements ImportEventListener
{
    /**
     * @var PlaylistRepository
     */
    protected $playlistFactory;

    /**
     * @param PlaylistFactory $playlistFactory
     */
    public function __construct(
        PlaylistFactory $playlistFactory
    ) {
        $this->playlistFactory = $playlistFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            ImportEventInterface::IMPORTED_COMPLETE => 'importCompleted',
        ];
    }

    /**
     * @param
     */
    public function importCompleted(): void
    {
        $this->playlistFactory->createLastImportedPlaylist();
    }
}
