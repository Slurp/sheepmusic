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
use SplFileInfo;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

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
     * @var ProgressBar
     */
    protected $progress;

    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @var SongsRepository
     */
    protected $songsRepository;

    /**
     * @var SongImporter
     */
    protected $songImporter;

    /**
     * @var bool $debug
     */
    protected $debug;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param SongImporter $songImporter
     *
     * @internal param EntityManager $entityManager
     */
    public function __construct(ManagerRegistry $managerRegistry, SongImporter $songImporter)
    {

        $this->managerRegistry = $managerRegistry;
        $this->songImporter = $songImporter;
    }

    /**
     * @param OutputInterface $output
     * @param bool $debug
     */
    public function setOutputInterface(OutputInterface $output, $debug = true)
    {
        $this->debug = $debug;
        $this->output = $output;
    }

    /**
     * @param $path
     */
    public function import($path)
    {
        $this->path = $path;
        // Make service calls out of these
        $this->songsRepository = $this->managerRegistry->getRepository(
            SongEntity::class
        );
        $importingFiles = $this->gatherFiles($this->path);
        if (count($importingFiles) > 0) {
            $this->setupProgressBar(count($importingFiles));
            /** @var SplFileInfo $file */
            foreach ($importingFiles as $file) {
                $this->songImporter->importSong($file);
                $this->debugStep('imported', $file->getFilename());
                unset($file);
            }
        }
        $this->debugEnd();
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
        return Finder::create()
            ->files()
            ->name('/\.(mp3|ogg|m4a|flac)$/i')
            ->in($path)
            //->date('since last week')
            ->sortByModifiedTime();
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
            $this->progress->setRedrawFrequency(100);
            $this->progress->setFormat('debug');
            if ($this->debug) {
                $this->progress->setFormat('%current%/%max% %elapsed:6s%/%estimated:-6s% %message% : %filename%');
            }
        }
    }

    /**
     * @param string $operation
     * @param string $info
     */
    protected function debugStep($operation, $info)
    {
        if ($this->progress !== null) {
            if ($this->debug) {
                $this->progress->setMessage("\n" . $operation);
                $this->progress->setMessage($info, 'filename');
            }
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
    }
}
