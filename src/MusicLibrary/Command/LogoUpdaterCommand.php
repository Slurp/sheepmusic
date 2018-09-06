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

use BlackSheep\MusicLibrary\Events\ArtistEvent;
use BlackSheep\MusicLibrary\Events\ArtistEventInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LogoUpdaterCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('black_sheep_music_library:logo_updater_command')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $artists = $this->getContainer()->get('black_sheep_music_library.repository.artists_repository')->findAll();
        foreach ($artists as $artist) {
            $this->getContainer()->get('event_dispatcher')->dispatch(
                ArtistEventInterface::ARTIST_EVENT_FETCHED,
                new ArtistEvent($artist)
            );
        }
    }
}
