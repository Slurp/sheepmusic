<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Command;

use BlackSheep\MusicLibrary\Helper\AlbumCoverHelper;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Model\ArtworkCollectionInterface;
use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;
use BlackSheep\MusicLibrary\Model\SongInterface;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use BlackSheep\MusicScanner\Helper\TagHelper;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Handler\UploadHandler;

/**
 * Class UpdaterCommand.
 */
class CleanupCommand extends AbstractProgressCommand
{
    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * @var AlbumsRepository
     */
    protected $albumsRepository;

    /**
     * @var AlbumCoverHelper
     */
    protected $albumCoverHelper;

    /**
     * @var TagHelper
     */
    private $tagHelper;

    /**
     * @var UploadHandler
     */
    private $uploadHandler;

    /**
     * CleanupCommand constructor.
     *
     * @param ArtistRepository $artistRepository
     * @param AlbumsRepository $albumsRepository
     * @param AlbumCoverHelper $albumCoverHelper
     * @param UploadHandler $uploadHandler
     */
    public function __construct(
        ArtistRepository $artistRepository,
        AlbumsRepository $albumsRepository,
        AlbumCoverHelper $albumCoverHelper,
        UploadHandler $uploadHandler
    ) {
        parent::__construct();
        $this->artistRepository = $artistRepository;
        $this->albumsRepository = $albumsRepository;
        $this->albumCoverHelper = $albumCoverHelper;
        $this->tagHelper = new TagHelper();
        $this->uploadHandler = $uploadHandler;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('library:cleanup')
            ->setDescription('Remove duped files. and creates diskspace.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOutputInterface($output);
        $artists = $this->artistRepository->findAll();
        /* @var ArtistInterface $artist */
        $this->setupProgressBar(\count($artists));
        foreach ($artists as $artist) {
            try {
                $this->cleanupArtworkType($artist, ArtworkInterface::TYPE_BACKGROUND);
                $this->cleanupArtworkType($artist, ArtworkInterface::TYPE_LOGO);
                $this->cleanupArtworkType($artist, ArtworkInterface::TYPE_COVER);
                $this->cleanupArtworkType($artist, ArtworkInterface::TYPE_BANNER);
                $this->cleanupArtworkType($artist, ArtworkInterface::TYPE_THUMBS);
                foreach ($artist->getAlbums() as $album) {
                    $this->cleanupArtworkType($album, ArtworkInterface::TYPE_COVER);
                    $this->albumsRepository->save($album);
                    if ($album->getCover() !== null &&
                        file_exists($this->albumCoverHelper->getWebDirectory() . $album->getCover()) === false
                    ) {
                        $song = $album->getSongs()->first();
                        if ($song instanceof SongInterface) {
                            $songInfo = $this->tagHelper->getInfo(new File($song->getPath()));
                            $album->setCover($songInfo['cover']);
                            $this->albumsRepository->save($album);
                        }
                    }
                }
                $this->artistRepository->save($artist);
                $this->debugStep('cleaned', $artist->getName());
            } catch (OptimisticLockException $exception) {
                $this->output->writeln($exception->getMessage());
            }
        }
        return self::SUCCESS;
    }

    protected function cleanupArtworkType(ArtworkCollectionInterface $artworkCollection, $type)
    {
        $initArtwork = null;
        $artworks = $artworkCollection->filterArtwork($type);
        if ($artworks !== null && \count($artworks) > 1) {
            foreach ($artworks as $artwork) {
                if (null !== $initArtwork) {
                    try {
                        $this->output->writeln($artwork->getType());
                        $this->uploadHandler->remove($artwork, 'imageFile');
                        $artworkCollection->removeArtwork($artwork);
                        $this->albumsRepository->remove($artwork);
                    } catch (\Exception $exception) {
                        $this->output->writeln($exception->getMessage());
                    }
                }
                $initArtwork = $artwork;
            }
        }
    }
}
