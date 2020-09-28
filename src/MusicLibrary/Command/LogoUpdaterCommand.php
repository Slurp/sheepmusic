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
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class LogoUpdaterCommand extends Command
{
    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * GenreUpdaterCommand constructor.
     *
     * @param ArtistRepository $artistRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        ArtistRepository $artistRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct();
        $this->artistRepository = $artistRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

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
        foreach ($this->artistRepository->findAll() as $artist) {
            $this->eventDispatcher->dispatch(
                new ArtistEvent($artist),
                ArtistEventInterface::ARTIST_EVENT_FETCHED
            );
        }
    }
}
