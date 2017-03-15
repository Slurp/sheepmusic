<?php
/**
 * @author    : Stephan Langeweg <stephan@zwartschaap.net>
 * @copyright 2016 Zwartschaap
 *
 * @version   1.0
 */

namespace BlackSheep\MusicScannerBundle\Services;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
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
     * @var SongImporter
     */
    protected $songImporter;

    /**
     */
    public function __construct()
    {
        $this->tagHelper = new TagHelper();
        $this->stopwatch = new Stopwatch();
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param SongImporter $songImporter
     */
    public function setSongImporter(SongImporter $songImporter)
    {
        $this->songImporter = $songImporter;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutputInterface(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param integer $max
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

    /**
     * @param $path
     */
    public function import($path)
    {
        $this->path = $path;
        $this->stopwatch->start('import_music');
        // Make service calls out of these
        $this->songsRepository = $this->entityManager->getRepository(SongEntity::class);

        $importingFiles = $this->gatherFiles($this->path);

        $this->setupProgressBar(count($importingFiles));

        /** @var SplFileInfo $file */
        foreach ($importingFiles as $file) {
            $this->stopwatch->lap('import_music');
            $songInfo = $this->tagHelper->getInfo($file);
            $songEntity = $this->songsRepository->needsImporting($songInfo);
            if ($songEntity === null || $songInfo['artist'] === '') {
                $this->songImporter->importSong($songInfo);
                $this->debugStep('ADDING', $songInfo['artist'] . ' ' . $songInfo['album'] . $file->getGroup());
            } else {
                $this->debugStep('SKIPPING', $songInfo['artist'] . ' ' . $songInfo['album']);
            }
        }
        $this->entityManager->flush();
        $this->debugEnd();
    }

    /**
     * @param string $operation
     * @param string $info
     */
    protected function debugStep($operation, $info)
    {
        if ($this->progress !== null) {
            $this->progress->setMessage("\n" . $operation);
            $this->progress->setMessage($info, 'filename');
            $this->progress->advance();
        }
    }

    /**
     *
     */
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
     * @return Finder An array of SplFileInfo objects
     */
    public function gatherFiles($path)
    {
        return Finder::create()->files()->name('/\.(mp3|ogg|m4a|flac)$/i')->in($path);
    }
}
