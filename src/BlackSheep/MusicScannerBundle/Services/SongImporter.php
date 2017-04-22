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
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepositoryInterface;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepositoryInterface;
use BlackSheep\MusicLibraryBundle\Repository\SongsRepositoryInterface;
use BlackSheep\MusicScannerBundle\Helper\TagHelper;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Finder\SplFileInfo;

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
     * @var \Doctrine\Common\Persistence\ObjectManager|null|object
     */
    protected $entitymanager;

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
        $this->songRepository = $this->managerRegistry->getRepository(SongEntity::class);
        $this->albumRepository = $this->managerRegistry->getRepository(AlbumEntity::class);
        $this->artistRepository = $this->managerRegistry->getRepository(ArtistsEntity::class);
        $this->entitymanager = $this->managerRegistry->getManagerForClass(SongEntity::class);
        $this->tagHelper = new TagHelper();
    }

    /**
     * @param SplFileInfo $file
     */
    public function importSong(SplFileInfo $file)
    {
        $songInfo = $this->tagHelper->getInfo($file);
        $songEntity = $this->songRepository->needsImporting($songInfo);
        if ($songEntity === null && empty($songInfo['artist']) === false) {
            $this->writeSong($songInfo);
        }
    }

    /**
     * @param $songInfo
     *
     * @return SongEntity
     */
    protected function writeSong(&$songInfo)
    {
        $artist = $this->artistImporter->importArtist($songInfo);
        $album = $this->albumImporter->importAlbum($artist, $songInfo);
        $song = SongEntity::createFromArray($songInfo);
        $album->addSong($song);
        $song->addArtist($artist);
        $this->entitymanager->persist($song);

        return $song;
    }
}
