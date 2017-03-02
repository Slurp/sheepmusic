<?php
/**
 * @author    : Stephan Langeweg <stephan@zwartschaap.net>
 * Date: 15/02/16
 * Time: 23:11
 * @copyright 2016 Zwartschaap
 *
 * @version   1.0
 */

namespace BlackSheep\MusicScannerBundle\Services;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
use BlackSheep\MusicLibraryBundle\LastFm\LastFmAlbum;
use BlackSheep\MusicLibraryBundle\LastFm\LastFmArtist;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Repository\AlbumsRepository;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepository;
use BlackSheep\MusicLibraryBundle\Repository\SongsRepository;
use BlackSheep\MusicScannerBundle\Helper\TagHelper;
use Doctrine\ORM\EntityManager;
use SplFileInfo;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Import some media.
 */
class MediaImporter
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * @var ProgressBar
     */
    protected $progress;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var SongsRepository
     */
    protected $songsRepository;

    /**
     * @var ArtistInterface
     */
    protected $artistCache;

    /**
     * @var AlbumInterface
     */
    protected $albumCache;

    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * @var AlbumsRepository
     */
    protected $albumRepository;

    /** @var LastFmArtist */
    protected $lastFmArtist;

    /** @var LastFmAlbum */
    protected $lastFmAlbum;

    /**
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->tagHelper = new TagHelper();
        $this->stopwatch = new Stopwatch();
    }

    /**
     * @param LastFmArtist $lastFmArtist
     * @param LastFmAlbum  $lastFmAlbum
     */
    public function setLastFmObjects(LastFmArtist $lastFmArtist, LastFmAlbum $lastFmAlbum)
    {
        $this->lastFmArtist = $lastFmArtist;
        $this->lastFmAlbum = $lastFmAlbum;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutputInterface(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param $max
     */
    protected function setupProgressBar($max)
    {
        $this->progress = null;
        if ($this->output !== null) {
            // create a new progress bar (50 units)
            $this->progress = new ProgressBar($this->output, $max);
            // start and displays the progress bar
            $this->progress->start($max);
            $this->progress->setRedrawFrequency(4);
            $this->progress->setFormat('%current%/%max% %elapsed:6s%/%estimated:-6s% %message% : %filename%');
        }
    }

    public function import()
    {
        $this->stopwatch->start('import_music');
        // Make service calls out of these
        $this->artistRepository = $this->entityManager->getRepository(ArtistsEntity::class);
        $this->albumRepository = $this->entityManager->getRepository(AlbumEntity::class);
        $this->songsRepository = $this->entityManager->getRepository(SongEntity::class);

        $importingFiles = $this->gatherFiles($this->path);

        $this->setupProgressBar(count($importingFiles));

        /** @var SplFileInfo $file */
        foreach ($importingFiles as $file) {
            $this->stopwatch->lap('import_music');
            $songInfo = $this->tagHelper->getInfo($file);
            $songEntity = $this->songsRepository->needsImporting($songInfo);
            if ($songEntity === null || $songInfo['artist'] === '') {
                $this->importSong($songInfo);
                $this->debugStep('ADDING', $songInfo['artist'] . ' ' . $songInfo['album'] . $file->getGroup());
            } else {
                $this->debugStep('SKIPPING', $songInfo['artist'] . ' ' . $songInfo['album']);
            }
        }
        $this->entityManager->flush();
        $this->debugEnd();
    }

    /**
     * @param $songInfo
     */
    protected function importArtist($songInfo)
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
    }

    /**
     * @param $songInfo
     */
    protected function importAlbum($songInfo)
    {
        $this->importArtist($songInfo);
        if ($this->albumCache === null || $this->albumCache->getName() !== $songInfo['album']) {
            $this->albumCache = $this->albumRepository->addOrUpdateByArtistAndName(
                $this->artistCache,
                $songInfo['album'],
                $songInfo
            );
            $this->lastFmAlbum->updateLastFmInfo($this->albumCache);
        }
    }

    /**
     * @param $songInfo
     */
    protected function importSong($songInfo)
    {
        $this->importAlbum($songInfo);
        /** @var SongEntity $songEntity */
        $songEntity = SongEntity::createFromArray($songInfo);
        $songEntity->addArtist($this->artistCache);
        $this->albumCache->addSong($songEntity);

        $this->entityManager->persist($songEntity);
        if ($this->albumCache instanceof AlbumEntity) {
            $this->entityManager->persist($this->albumCache);
        }
        if ($this->artistCache instanceof ArtistsEntity) {
            $this->entityManager->persist($this->artistCache);
        } else {
            $this->artistCache = null;
        }
    }

    /**
     * @param $operation
     * @param $info
     */
    protected function debugStep($operation, $info)
    {
        if ($this->progress !== null) {
            $this->progress->setMessage("\n" . $operation);
            $this->progress->setMessage($info, 'filename');
            $this->progress->advance();
        }
    }

    protected function debugEnd()
    {
        if ($this->progress !== null) {
            $this->progress->finish();
        }
        if ($this->output !== null) {
            $event = $this->stopwatch->stop('import_music');
            $this->output->writeln($event->getDuration() / 100 . 'S');
        }
    }

    /**
     * Gather all applicable files in a given directory.
     *
     * @param string $path The directory's full path
     *
     * @return array An array of SplFileInfo objects
     */
    public function gatherFiles($path)
    {
        return Finder::create()->files()->name('/\.(mp3|ogg|m4a|flac)$/i')->in($path);
    }
}
