<?php
/**
 * @author    : Stephan Langeweg <stephan@zwartschaap.net>
 * @copyright 2016 Zwartschaap
 *
 * @version   1.0
 */
namespace BlackSheep\MusicScannerBundle\Services;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
use BlackSheep\MusicLibraryBundle\LastFm\LastFmAlbum;
use BlackSheep\MusicLibraryBundle\LastFm\LastFmArtist;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepository;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepository;
use Doctrine\ORM\EntityManager;

/**
 * Imports a song based on array information
 */
class SongImporter
{
    /** @var LastFmArtist */
    protected $lastFmArtist;

    /** @var LastFmAlbum */
    protected $lastFmAlbum;

    /**
     * @var ArtistInterface
     */
    protected $artistCache;

    /**
     * @var AlbumInterface
     */
    protected $albumCache;

    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * @var AlbumsRepository
     */
    protected $albumRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->artistRepository = $this->entityManager->getRepository(ArtistsEntity::class);
        $this->albumRepository = $this->entityManager->getRepository(AlbumEntity::class);
        }

    /**
     * @param LastFmArtist $lastFmArtist
     * @param LastFmAlbum $lastFmAlbum
     */
    public function setLastFmObjects(LastFmArtist $lastFmArtist, LastFmAlbum $lastFmAlbum)
    {
        $this->lastFmArtist = $lastFmArtist;
        $this->lastFmAlbum = $lastFmAlbum;
    }

    /**
     * @param $songInfo
     */
    public function importSong($songInfo)
    {
        $this->importAlbum($songInfo);
        $songEntity = SongEntity::createFromArray($songInfo);
        $songEntity->addArtist($this->artistCache);
        $this->albumCache->addSong($songEntity);

        $this->entityManager->persist($songEntity);
        if ($this->albumCache instanceof AlbumEntity) {
            $this->entityManager->persist($this->albumCache);
        }
        if ($this->artistCache instanceof ArtistsEntity) {
            $this->entityManager->persist($this->artistCache);
        } else {
            $this->artistCache = null;
        }
    }

    /**
     * @param $songInfo
     */
    protected function importAlbum($songInfo)
    {
        $this->importArtist($songInfo);
        if ($this->albumCache === null || $this->albumCache->getName() !== $songInfo['album']) {
            $this->albumCache = $this->albumRepository->addOrUpdateByArtistAndName(
                $this->artistCache,
                $songInfo['album'],
                $songInfo
            );
            $this->lastFmAlbum->updateLastFmInfo($this->albumCache);
        }
    }

    /**
     * @param $songInfo
     */
    protected function importArtist($songInfo)
    {
        if ($this->artistCache === null ||
            (
                $this->artistCache->getName() !== $songInfo['artist'] ||
                $songInfo['artist_mbid'] !== $this->artistCache->getMusicBrainzId()
            )
        ) {
            $this->artistCache = $this->artistRepository->addOrUpdate($songInfo['artist'], $songInfo['artist_mbid']);
            $this->lastFmArtist->updateLastFmInfo($this->artistCache);
        }
    }
}
