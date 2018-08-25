<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\Services;

use BlackSheep\MusicLibrary\Entity\GenreEntity;
use BlackSheep\MusicLibrary\Entity\SongEntity;
use BlackSheep\MusicLibrary\Repository\GenresRepository;
use BlackSheep\MusicLibrary\Repository\SongsRepository;
use BlackSheep\MusicScanner\Helper\TagHelper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Imports a song based on array information.
 */
class SongImporter
{
    /**
     * @var AlbumImporter
     */
    protected $albumImporter;

    /**
     * @var ArtistImporter
     */
    protected $artistImporter;

    /**
     * @var SongsRepository
     */
    protected $songRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager|null|object
     */
    protected $entitymanager;

    /**
     * @var TagHelper
     */
    protected $tagHelper;

    /**
     * @var GenresRepository|\Doctrine\Common\Persistence\ObjectRepository
     */
    protected $genreRepository;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param AlbumImporter $albumImporter
     * @param ArtistImporter $artistImporter
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        AlbumImporter $albumImporter,
        ArtistImporter $artistImporter
    ) {
        $this->albumImporter = $albumImporter;
        $this->artistImporter = $artistImporter;
        $this->songRepository = $managerRegistry->getRepository(SongEntity::class);
        $this->entitymanager = $managerRegistry->getManagerForClass(SongEntity::class);
        $this->genreRepository = $managerRegistry->getRepository(GenreEntity::class);
        $this->tagHelper = new TagHelper();
    }

    /**
     * @param SplFileInfo $file
     *
     * @return SongEntity|null
     */
    public function importSong(SplFileInfo $file)
    {
        $songInfo = $this->tagHelper->getInfo($file);
        $songEntity = $this->songRepository->needsImporting($songInfo);
        if ($songEntity === null && empty($songInfo['artist']) === false) {
            return $this->writeSong($songInfo);
        }

        return null;
    }

    /**
     * @param $songInfo
     *
     * @return SongEntity
     */
    protected function writeSong(&$songInfo)
    {
        $artist = $this->artistImporter->importArtist($songInfo);
        $album = $this->albumImporter->importAlbum($artist, $songInfo);
        if (empty($songInfo['track'])) {
            $songInfo['track'] = count($album->getSongs());
        }
        $song = SongEntity::createFromArray($songInfo);
        $album->addSong($song);
        $song->addArtist($artist);
        if ($songInfo['genre'] !== '') {
            $genre = $this->genreRepository->addOrUpdateByName($songInfo['genre']);
            $song->setGenre($genre);
        }
        $this->entitymanager->persist($song);

        return $song;
    }
}
