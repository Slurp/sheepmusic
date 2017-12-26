<?php

namespace BlackSheep\MusicLibraryBundle\Command;

use BlackSheep\MusicLibraryBundle\Events\ArtistEvent;
use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
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
