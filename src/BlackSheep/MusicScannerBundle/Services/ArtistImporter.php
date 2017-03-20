<?php
/**
 * @author    : Stephan Langeweg <stephan@zwartschaap.net>
 * @copyright 2016 Zwartschaap
 *
 * @version   1.0
 */
namespace BlackSheep\MusicScannerBundle\Services;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\LastFm\LastFmArtist;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepository;
use Doctrine\ORM\EntityManager;

/**
 * Imports a song based on array information
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
     * @param EntityManager $entityManager
     * @param LastFmArtist $lastFmArtist
     */
    public function __construct(EntityManager $entityManager, LastFmArtist $lastFmArtist)
    {
        $this->artistRepository = $entityManager->getRepository(ArtistsEntity::class);
        $this->lastFmArtist = $lastFmArtist;
    }

    /**
     * @param $songInfo
     *
     * @return ArtistInterface
     */
    public function importArtist($songInfo)
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
        return $this->artistCache;
    }
}
