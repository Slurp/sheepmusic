<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\Services;

use BlackSheep\MusicLibrary\Entity\SongEntity;
use BlackSheep\MusicLibrary\Repository\SongsRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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
     * @var bool
     */
    protected $debug;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param SongImporter    $songImporter
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
     * @param bool            $debug
     */
    public function setOutputInterface(OutputInterface $output, bool $debug = true)
    {
        $this->debug = $debug;
        $this->output = $output;
    }

    /**
     * @param string $path
     * @param boolean $fullImport
     */
    public function import(string $path, $fullImport)
    {
        $this->path = $path;
        if ($this->output !== null) {
            $this->output->writeln('importing:' . $this->path);
        }
        $importingFiles = $this->gatherFiles(
            $this->path,
            $fullImport ? null : $this->managerRegistry->getRepository(
                SongEntity::class
            )->lastImportDate()
        );
        $this->output->writeln('start of importing:' . $this->path);
        if ($importingFiles->count() > 0) {
            $this->output->writeln('start of importing:' . $this->path);
            $this->setupProgressBar($importingFiles->count());
            /** @var SplFileInfo $file */
            foreach ($importingFiles as $file) {
                try {
                    $this->songImporter->importSong($file);
                } catch (\Exception $exception) {
                    $this->output->writeln([$exception->getMessage(), $exception->getLine(), $exception->getFile()]);
                    $this->output->write($exception->getTraceAsString());
                    die();
                }
                $this->debugStep('imported', $file->getFilename());
                unset($file);
            }
            $this->managerRegistry->getManager()->flush();
        }
        $this->debugEnd();
    }

    /**
     * Gather all applicable files in a given directory.
     *
     * @param string         $path           The directory's full path
     * @param \DateTime|null $lastImportDate
     *
     * @return Finder An array of SplFileInfo objects
     */
    public function gatherFiles($path, \DateTime $lastImportDate = null): Finder
    {
        $finder = Finder::create()
            ->files()
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(true)
            ->name('/\.(mp3|ogg|m4a|flac)$/i')
            ->in($path);
        if ($lastImportDate !== null) {
            $finder->date('>=' . $lastImportDate->format('Y-m-d'));
            $finder->sortByModifiedTime();
        }
        $this->output->writeln('created finder');

        return $finder;
    }

    /**
     * @param int $max
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

    protected function debugEnd()
    {
        if ($this->progress !== null) {
            $this->progress->finish();
        }
    }
}
