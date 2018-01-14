<?php

namespace BlackSheep\MusicLibraryBundle\Command;

use BlackSheep\MusicLibraryBundle\Events\ArtistEvent;
use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdaterCommand.
 */
class UpdaterCommand extends ContainerAwareCommand
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var ProgressBar
     */
    protected $progress;

    /**
     * @var bool
     */
    protected $debug;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('library:update')
            ->setDescription('Update all metadata for everthing. Takes a while!');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOutputInterface($output);
        $artistRepository = $this->getContainer()->get('black_sheep_music_library.repository.artists_repository');
        $artists = $artistRepository->findAll();
        /* @var ArtistInterface $artist */
        $this->setupProgressBar(count($artists));
        foreach ($artists as $artist) {
            $this->getContainer()->get('event_dispatcher')->dispatch(
                ArtistEventInterface::ARTIST_EVENT_FETCHED,
                new ArtistEvent($artist)
            );
            $genres = $this->updateAlbumGenre($artist);
            if (count($genres) > 0) {
                $artist->setGenres($genres);
            }
            $artistRepository->save($artist);
            $this->debugStep('updated', $artist->getName());
        }
    }

    /**
     * @param OutputInterface $output
     * @param bool            $debug
     */
    public function setOutputInterface(OutputInterface $output, $debug = true)
    {
        $this->debug = $debug;
        $this->output = $output;
    }

    /**
     * @param ArtistInterface $artist
     *
     * @return array
     */
    protected function updateAlbumGenre(ArtistInterface $artist)
    {
        $genres = [];
        foreach ($artist->getAlbums() as $album) {
            if ($album->getSongs() &&
                $album->getSongs()->first() !== false) {
                $album->setLossless($album->getSongs()->first()->getAudio()->getLossless());
                if ($album->getSongs()->first()->getGenre() !== '' &&
                    $album->getSongs()->first()->getGenre() !== null) {
                    $album->setGenre($album->getSongs()->first()->getGenre());
                    $genres[$album->getGenre()->getSlug()] = $album->getGenre();
                }
                $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush($album);
            }
        }

        return $genres;
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
            $this->progress->setRedrawFrequency(1);
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
