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

use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\LastFm\LastFmAlbum;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Imports a song based on array information.
 */
class AlbumImporter
{
    /**
     * @var LastFmAlbum
     */
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
     * @param ArtistInterface $artist
     * @param array           $songInfo
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return AlbumInterface
     */
    public function importAlbum(ArtistInterface $artist, &$songInfo): AlbumInterface
    {
        if ($this->albumCache === null ||
            $this->albumCache->getName() !== $songInfo['album'] ||
            (
                isset($songInfo['album_mbid']) && empty($songInfo['album_mbid']) === false &&
                $this->albumCache->getMusicBrainzId() !== $songInfo['album_mbid']
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
        }
        if ($this->albumCache->getMusicBrainzId() === null && empty($songInfo['album_mbid']) === false) {
            $this->albumCache->setMusicBrainzId($songInfo['album_mbid']);
            $this->albumRepository->save($this->albumCache);
        }

        return $this->albumCache;
    }

    /**
     * @return bool
     */
    protected function addMetaDataToNewAlbum(): bool
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
