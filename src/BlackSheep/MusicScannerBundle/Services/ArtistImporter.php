<?php

namespace BlackSheep\MusicScannerBundle\Services;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\LastFm\LastFmArtist;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Imports a song based on array information.
 */
class ArtistImporter
{
    /** @var LastFmArtist */
    protected $lastFmArtist;

    /**
     * @var ArtistInterface
     */
    protected $artistCache;

    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param LastFmArtist    $lastFmArtist
     */
    public function __construct(ManagerRegistry $managerRegistry, LastFmArtist $lastFmArtist)
    {
        $this->artistRepository = $managerRegistry->getRepository(
            ArtistsEntity::class
        );
        $this->lastFmArtist = $lastFmArtist;
    }

    /**
     * @param $songInfo
     *
     * @return ArtistInterface
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function importArtist(&$songInfo): ArtistInterface
    {
        if ($this->artistCache === null ||
            (
                $this->artistCache->getName() !== $songInfo['artist'] ||
                $songInfo['artist_mbid'] != $this->artistCache->getMusicBrainzId()
            )
        ) {
            $this->artistCache = $this->artistRepository->addOrUpdate($songInfo['artist'], $songInfo['artist_mbid']);
            if ($this->artistCache->getId() === null) {
                try {
                    $this->lastFmArtist->updateLastFmInfo($this->artistCache);
                    $artist = null;
                    //Check if lastfm updated stuff is not already available
                    if ($this->artistCache->getMusicBrainzId() !== null) {
                        $artist = $this->artistRepository->getArtistByMusicBrainzId(
                            $this->artistCache->getMusicBrainzId()
                        );
                    }
                    if ($artist === null) {
                        $artist = $this->artistRepository->getArtistByName(
                            $this->artistCache->getName()
                        );
                    }
                    if ($artist !== null) {
                        unset($this->artistCache);
                        $this->artistCache = $artist;
                        unset($artist);

                        return $this->artistCache;
                    }
                } catch (\Exception $exception) {
                    error_log($exception->getFile() . $exception->getLine() . $exception->getMessage());
                }
            }

            $this->artistRepository->save($this->artistCache);
        }
        if ($this->artistCache->getMusicBrainzId() === null && empty($songInfo['artist_mbid']) === false) {
            $this->artistCache->setMusicBrainzId($songInfo['artist_mbid']);
            $this->artistRepository->save($this->artistCache);
        }

        return $this->artistCache;
    }
}
