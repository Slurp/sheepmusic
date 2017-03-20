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
use Doctrine\ORM\EntityManager;

/**
 * Imports a song based on array information
 */
class SongImporter
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var AlbumImporter
     */
    protected $albumImporter;

    /**
     * @var ArtistImporter
     */
    protected $artistImporter;

    /**
     * @param EntityManager $entityManager
     * @param AlbumImporter $albumImporter
     * @param ArtistImporter $artistImporter
     */
    public function __construct(
        EntityManager $entityManager,
        AlbumImporter $albumImporter,
        ArtistImporter $artistImporter
    ) {
        $this->entityManager = $entityManager;
        $this->albumImporter = $albumImporter;
        $this->artistImporter = $artistImporter;
    }

    /**
     * @param $songInfo
     *
     * @return SongEntity
     */
    public function importSong($songInfo)
    {
        $artist = $this->artistImporter->importArtist($songInfo);
        $album = $this->albumImporter->importAlbum($artist, $songInfo);

        $songEntity = SongEntity::createFromArray($songInfo);
        $album->addSong($songEntity);
        $songEntity->addArtist($artist);

        $this->entityManager->persist($songEntity);
        if ($album instanceof AlbumEntity) {
            $this->entityManager->persist($album);
        }
        if ($artist instanceof ArtistsEntity) {
            $this->entityManager->persist($artist);
        }
        return $songEntity;
    }
}
