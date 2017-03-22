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
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * Imports a song based on array information
 */
class SongImporter
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @var AlbumImporter
     */
    protected $albumImporter;

    /**
     * @var ArtistImporter
     */
    protected $artistImporter;

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
        $this->managerRegistry = $managerRegistry;
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

        $this->managerRegistry->getManagerForClass(SongEntity::class)->persist($songEntity);
        if ($album instanceof AlbumEntity) {
            $this->managerRegistry->getManagerForClass(AlbumEntity::class)->persist($album);
        }
        if ($artist instanceof ArtistsEntity) {
            $this->managerRegistry->getManagerForClass(ArtistsEntity::class)->persist($artist);
        }
        return $songEntity;
    }
}
