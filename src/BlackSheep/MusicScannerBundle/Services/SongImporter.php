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
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepositoryInterface;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepositoryInterface;
use BlackSheep\MusicLibraryBundle\Repository\SongsRepositoryInterface;
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
     * @var SongsRepositoryInterface
     */
    protected $songRepository;

    /**
     * @var AlbumsRepositoryInterface
     */
    protected $albumRepository;

    /**
     * @var ArtistRepositoryInterface
     */
    protected $artistRepository;

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
        $this->songRepository = $this->managerRegistry->getManagerForClass(SongEntity::class);
        $this->albumRepository = $this->managerRegistry->getManagerForClass(AlbumEntity::class);
        $this->artistRepository = $this->managerRegistry->getManagerForClass(ArtistsEntity::class);
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
        $song = SongEntity::createFromArray($songInfo);
        $album->addSong($song);
        $song->addArtist($artist);
        $this->songRepository->persist($song);

        return $song;
    }
}
