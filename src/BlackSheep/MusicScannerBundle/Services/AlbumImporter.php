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
use BlackSheep\MusicLibraryBundle\LastFm\LastFmAlbum;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\Artist;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepository;
use Doctrine\ORM\EntityManager;

/**
 * Imports a song based on array information
 */
class AlbumImporter
{
    /** @var LastFmAlbum */
    protected $lastFmAlbum;

    /**
     * @var AlbumInterface
     */
    protected $albumCache;

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
     * @param LastFmAlbum $lastFmAlbum
     */
    public function __construct(EntityManager $entityManager, LastFmAlbum $lastFmAlbum)
    {
        $this->albumRepository = $entityManager->getRepository(AlbumEntity::class);
        $this->lastFmAlbum = $lastFmAlbum;
    }

    /**
     * @param ArtistsEntity $artist
     * @param $songInfo
     *
     * @return AlbumInterface
     */
    public function importAlbum(ArtistsEntity $artist, $songInfo)
    {
        if ($this->albumCache === null || $this->albumCache->getName() !== $songInfo['album']) {
            $this->albumCache = $this->albumRepository->addOrUpdateByArtistAndName(
                $artist,
                $songInfo['album'],
                $songInfo
            );
            $this->lastFmAlbum->updateLastFmInfo($this->albumCache);
        }
        return $this->albumCache;
    }
}
