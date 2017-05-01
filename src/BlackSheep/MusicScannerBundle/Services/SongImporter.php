<?php
/**
 * @author    : Stephan Langeweg <stephan@zwartschaap.net>
 * @copyright 2016 Zwartschaap
 *
 * @version   1.0
 */

namespace BlackSheep\MusicScannerBundle\Services;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
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
     * @var \Doctrine\Common\Persistence\ObjectManager|null|object
     */
    protected $entitymanager;

    /**
     * @var TagHelper
     */
    protected $tagHelper;

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
        $this->albumImporter = $albumImporter;
        $this->artistImporter = $artistImporter;
        $this->songRepository = $managerRegistry->getRepository(SongEntity::class);
        $this->entitymanager = $managerRegistry->getManagerForClass(SongEntity::class);
        $this->tagHelper = new TagHelper();
    }

    /**
     * @param SplFileInfo $file
     *
     * @return SongEntity|null
     */
    public function importSong(SplFileInfo $file)
    {
        $songInfo = $this->tagHelper->getInfo($file);
        $songEntity = $this->songRepository->needsImporting($songInfo);
        if ($songEntity === null && empty($songInfo['artist']) === false) {
            return $this->writeSong($songInfo);
        }

        return null;
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
