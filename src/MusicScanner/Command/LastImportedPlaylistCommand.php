<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\Command;

use BlackSheep\MusicScanner\Event\ImportEventInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Commando: music import.
 */
class LastImportedPlaylistCommand extends Command
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct('music_scanner:last_imported_playlist');
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('generates a playlist for the last imported items');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventDispatcher->dispatch(new Event(),ImportEventInterface::IMPORTED_COMPLETE);
    }
}
