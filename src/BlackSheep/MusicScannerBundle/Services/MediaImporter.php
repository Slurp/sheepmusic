<?php
/**
 * @author: Stephan Langeweg <stephan@zwartschaap.net>
 * Date: 15/02/16
 * Time: 23:11
 * @copyright 2016 Zwartschaap
 * @version 1.0
 */
namespace BlackSheep\MusicScannerBundle\Services;

use BlackSheep\MusicLibraryBundle\Entity\Albums;
use BlackSheep\MusicLibraryBundle\Entity\Artists;
use BlackSheep\MusicLibraryBundle\Entity\Songs;
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
 *
 */
class MediaImporter
{

    /**
     * @var string
     */
    protected $path;

    /**
     * @var OutputInterface $output
     */
    protected $output;

    /**
     * @var Stopwatch $stopwatch
     */
    protected $stopwatch;

    /**
     * @var ProgressBar $progress
     */
    protected $progress;

    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var SongsRepository $songsRepository
     */
    protected $songsRepository;


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
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->songsRepository = $entityManager->getRepository(Songs::class);
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
        $importingFiles = $this->gatherFiles($this->path);
        $this->setupProgressBar(count($importingFiles));

        /** @var Artists $artistCache */
        $artistCache = null;
        /** @var Albums $albumCache */
        $albumCache = null;
        /** @var ArtistRepository $artistRepository */
        $artistRepository = $this->entityManager->getRepository(Artists::class);
        /** @var AlbumsRepository $albumRepository */
        $albumRepository = $this->entityManager->getRepository(Albums::class);
        /** @var SplFileInfo $file */
        foreach ($importingFiles as $file) {
            $this->stopwatch->lap('import_music');
            $songInfo = $this->tagHelper->getInfo($file);
            $songEntity = $this->songsRepository->needsImporting($songInfo);
            if ($songEntity === null) {

                if ($artistCache === null || $artistCache->getName() !== $songInfo['artist']) {
                    $artistCache = $artistRepository->addOrUpdateByName($songInfo['artist']);
                }
                if ($albumCache === null || $albumCache->getName() !== $songInfo['album']) {
                    $albumCache = $albumRepository->addOrUpdateByArtistAndName(
                        $artistCache,
                        $songInfo['album'],
                        $songInfo
                    );
                }


                /** @var Songs $songEntity */
                $songEntity = Songs::createFromArray($songInfo);
                $songEntity->addArtist($artistCache);
                $albumCache->addSong($songEntity);

                $this->entityManager->persist($songEntity);
                if ($albumCache instanceof Albums) {
                    $this->entityManager->persist($albumCache);
                }
                if ($artistCache instanceof Artists) {
                    $this->entityManager->persist($artistCache);
                } else {
                    $artistCache = null;
                }

                $this->debugStep("ADDING", $songInfo['artist'] . " " . $songInfo['album']);
            } else {
                $this->debugStep("SKIPPING", $songInfo['artist'] . " " . $songInfo['album']);
            }
        }
        $this->entityManager->flush();
        $this->debugEnd();
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
