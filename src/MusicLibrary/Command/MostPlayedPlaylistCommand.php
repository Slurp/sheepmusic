<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Command;

use BlackSheep\MusicLibrary\Factory\PlaylistFactory;
use BlackSheep\MusicScanner\Event\ImportEventInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commando: music import.
 */
class MostPlayedPlaylistCommand extends ContainerAwareCommand
{
    private $playlistFactory;

    public function __construct(PlaylistFactory $playlistFactory)
    {
        $this->playlistFactory = $playlistFactory;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('music_library:most_played_playlist')
            ->setDescription('generates a playlist with the most played songs');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->playlistFactory->createMostPlayedPlaylist();
    }
}
