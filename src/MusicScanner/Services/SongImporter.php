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
use BlackSheep\MusicLibrary\Model\SongInterface;
use BlackSheep\MusicLibrary\Repository\GenresRepository;
use BlackSheep\MusicLibrary\Repository\SongsRepository;
use BlackSheep\MusicScanner\Helper\TagHelper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
     * @var EntityManager
     */
    protected $entitymanager;

    /**
     * @var TagHelper
     */
    protected $tagHelper;

    /**
     * @var GenresRepository
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
        $this->genreRepository = $managerRegistry->getRepository(GenreEntity::class);
        $this->entitymanager = $managerRegistry->getManager();

        $this->tagHelper = new TagHelper();
    }

    /**
     * @param SplFileInfo $file
     *
     * @return SongInterface
     * @throws ORMException
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
     * @param array $songInfo
     *
     * @return SongInterface
     * @throws OptimisticLockException
     * @throws ORMException
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
        $this->songRepository->save($song);

        return $song;
    }
}
