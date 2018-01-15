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
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Imports a song based on array information.
 */
class AlbumImporter
{
    /** @var LastFmAlbum */
    protected $lastFmAlbum;

    /**
     * @var AlbumEntity
     */
    protected $albumCache;

    /**
     * @var AlbumsRepository
     */
    protected $albumRepository;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param LastFmAlbum     $lastFmAlbum
     */
    public function __construct(ManagerRegistry $managerRegistry, LastFmAlbum $lastFmAlbum)
    {
        $this->albumRepository = $managerRegistry->getRepository(
            AlbumEntity::class
        );
        $this->lastFmAlbum = $lastFmAlbum;
    }

    /**
     * @param ArtistsEntity $artist
     * @param $songInfo
     *
     * @return AlbumInterface
     */
    public function importAlbum(ArtistsEntity $artist, &$songInfo)
    {
        if ($this->albumCache === null ||
            $this->albumCache->getName() !== $songInfo['album'] ||
            (
                isset($songInfo['album_mbid']) && empty($songInfo['album_mbid']) === false &&
                $this->albumCache->getMusicBrainzId() != $songInfo['album_mbid']
            )
        ) {
            $this->albumCache = $this->albumRepository->addOrUpdateByArtistAndName(
                $artist,
                $songInfo['album'],
                $songInfo
            );
            if ($this->albumCache->getId() === null) {
                if ($this->addMetaDataToNewAlbum()) {
                    $this->albumRepository->save($this->albumCache);
                }
            }
            if ($this->albumCache->getMusicBrainzId() === null && empty($songInfo['album_mbid']) === false) {
                $this->albumCache->setMusicBrainzId($songInfo['album_mbid']);
                $this->albumRepository->save($this->albumCache);
            }
        }
        if ($this->albumCache->getMusicBrainzId() === null && empty($songInfo['album_mbid']) === false) {
            $this->albumCache->setMusicBrainzId($songInfo['album_mbid']);
            $this->albumRepository->save($this->albumCache);
        }

        return $this->albumCache;
    }

    protected function addMetaDataToNewAlbum()
    {
        try {
            $this->lastFmAlbum->updateLastFmInfo($this->albumCache);
            $album = null;
            if ($this->albumCache->getMusicBrainzId() !== null) {
                $album = $this->albumRepository->getArtistAlbumByMBID(
                    $this->albumCache->getMusicBrainzId()
                );
            } else {
                $album = $this->albumRepository->getArtistAlbumByName(
                    $this->albumCache->getArtist(),
                    $this->albumCache->getName()
                );
            }
            // already updated album..
            if ($album !== null) {
                unset($this->albumCache);
                $this->albumCache = $album;
                unset($album);

                return false;
            }
        } catch (\Exception $exception) {
            error_log($exception->getFile() . $exception->getLine() . $exception->getMessage());
        }

        return true;
    }
}
