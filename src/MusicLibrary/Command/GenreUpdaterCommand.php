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

use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenreUpdaterCommand.
 */
class GenreUpdaterCommand extends Command
{
    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * GenreUpdaterCommand constructor.
     *
     * @param ArtistRepository $artistRepository
     */
    public function __construct(
        ArtistRepository $artistRepository
    ) {
        parent::__construct();
        $this->artistRepository = $artistRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('black_sheep_music_library:genre_updater_command')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ArtistInterface $artist */
        foreach ($this->artistRepository->findAll() as $artist) {
            $genres = $this->updateAlbumGenre($artist);
            if (\count($genres) > 0) {
                $artist->setGenres($genres);
            }
        }
    }

    /**
     * @param ArtistInterface $artist
     *
     * @return array
     */
    protected function updateAlbumGenre(ArtistInterface $artist)
    {
        $genres = [];
        foreach ($artist->getAlbums() as $album) {
            if ($album->getSongs() &&
                $album->getSongs()->first() !== null &&
                $album->getSongs()->first()->getGenre() !== '' &&
                $album->getSongs()->first()->getGenre() !== null) {
                $genres[$album->getSlug()] = $album->getSongs()->first()->getGenre();
                $album->setGenre($genres[$album->getSlug()]);
            }
        }

        return $genres;
    }
}
