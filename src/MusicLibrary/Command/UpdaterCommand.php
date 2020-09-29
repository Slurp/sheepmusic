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

use BlackSheep\MusicLibrary\Events\AlbumEvent;
use BlackSheep\MusicLibrary\Events\ArtistEvent;
use BlackSheep\MusicLibrary\Events\ArtistEventInterface;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class UpdaterCommand.
 */
class UpdaterCommand extends AbstractProgressCommand
{
    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var AlbumsRepository
     */
    protected $albumsRepository;

    /**
     * UpdaterCommand constructor.
     *
     * @param ArtistRepository $artistRepository
     * @param AlbumsRepository $albumsRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        ArtistRepository $artistRepository,
        AlbumsRepository $albumsRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct();
        $this->artistRepository = $artistRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->albumsRepository = $albumsRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('library:update')
            ->setDescription('Update all metadata for everthing. Takes a while!');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOutputInterface($output);
        $artists = $this->artistRepository->findAll();
        /* @var ArtistInterface $artist */
        $this->setupProgressBar(\count($artists));
        foreach ($artists as $artist) {
            try {
                $genres = $this->updateAlbumGenre($artist);
                if (\count($genres) > 0) {
                    $artist->setGenres($genres);
                }
                $this->eventDispatcher->dispatch(
                    new ArtistEvent($artist),
                    ArtistEventInterface::ARTIST_EVENT_UPDATED,
                );
                $this->artistRepository->save($artist);
                $this->debugStep('updated', $artist->getName());
            } catch (OptimisticLockException $e) {
            }
        }

        return self::SUCCESS;
    }

    /**
     * @param OutputInterface $output
     * @param bool $debug
     */
    public function setOutputInterface(OutputInterface $output, $debug = true)
    {
        $this->debug = $debug;
        $this->output = $output;
    }

    /**
     * @param ArtistInterface $artist
     *
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     */
    protected function updateAlbumGenre(ArtistInterface $artist)
    {
        $genres = [];
        foreach ($artist->getAlbums() as $album) {
            if ($album->getSongs() &&
                $album->getSongs()->first() !== false) {
                $album->setLossless($album->getSongs()->first()->getAudio()->getLossless());
                if ($album->getSongs()->first()->getGenre() !== '' &&
                    $album->getSongs()->first()->getGenre() !== null) {
                    $album->setGenre($album->getSongs()->first()->getGenre());
                    $genres[$album->getGenre()->getSlug()] = $album->getGenre();
                }
            }
            $this->eventDispatcher->dispatch(
                new AlbumEvent($album),
                AlbumEvent::ALBUM_EVENT_UPDATED,
            );
            $this->albumsRepository->save($album);
        }

        return $genres;
    }
}
