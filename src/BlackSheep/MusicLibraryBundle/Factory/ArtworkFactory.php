<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Factory;

use BlackSheep\FanartTvBundle\Model\FanartTvResponse;
use BlackSheep\MusicLibraryBundle\Entity\Media\AlbumArtworkEntity;
use BlackSheep\MusicLibraryBundle\Entity\Media\ArtistArtworkEntity;
use BlackSheep\MusicLibraryBundle\Factory\Media\AbstractMediaFactory;
use BlackSheep\MusicLibraryBundle\Model\AlbumArtworkSetInterface;
use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtworkCollectionInterface;
use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;

/**
 * Class ArtworkFactory.
 */
class ArtworkFactory extends AbstractMediaFactory
{
    /**
     * @param ArtistInterface $artist
     * @param FanartTvResponse $artworkSet
     */
    public function addArtworkToArtist(ArtistInterface $artist, FanartTvResponse $artworkSet)
    {
        if (count($artist->getArtworks()) === 0) {
            $this->createArtwork($artist, ArtworkInterface::TYPE_LOGO, $artworkSet->getLogos());
            $this->createArtwork($artist, ArtworkInterface::TYPE_BACKGROUND, $artworkSet->getBackgrounds());
            $this->createArtwork($artist, ArtworkInterface::TYPE_BANNER, $artworkSet->getBanners());
            $this->createArtwork($artist, ArtworkInterface::TYPE_THUMBS, $artworkSet->getThumbs());
        }
        $this->updateAlbumsForArtist($artist, $artworkSet);
    }

    /**
     * @param ArtistInterface $artist
     * @param FanartTvResponse $artworkSet
     */
    protected function updateAlbumsForArtist(ArtistInterface $artist, FanartTvResponse $artworkSet)
    {
        if ($artworkSet->getArtworkCover() !== null || $artworkSet->getCdArt() !== null) {
            foreach ($artist->getAlbums() as $album) {
                if ($album->getMusicBrainzId() !== null &&
                    (count($album->getArtworkCover()) === 0 || count($album->getArtworkCover()) === 0)
                ) {
                    if (isset($artworkSet->getArtworkCover()[$album->getMusicBrainzReleaseGroupId()]) &&
                        count($album->getArtworkCover()) === 0
                    ) {
                        $this->createArtwork(
                            $album,
                            ArtworkInterface::TYPE_COVER,
                            $artworkSet->getArtworkCover()[$album->getMusicBrainzReleaseGroupId()]
                        );
                    }
                    if (isset($artworkSet->getCdArt()[$album->getMusicBrainzReleaseGroupId()]) &&
                        count($album->getCdArt()) === 0
                    ) {
                        $this->createArtwork(
                            $album,
                            ArtworkInterface::TYPE_CDART,
                            $artworkSet->getCdArt()[$album->getMusicBrainzReleaseGroupId()]
                        );
                    }
                }
            }
        }
    }

    /**
     * @param AlbumInterface $album
     * @param AlbumArtworkSetInterface $artworkSet
     */
    public function addArtworkToAlbum(AlbumInterface $album, AlbumArtworkSetInterface $artworkSet)
    {
        if ($artworkSet->getArtworkCover() !== null) {
            $this->createArtwork($album, ArtworkInterface::TYPE_COVER, $artworkSet->getArtworkCover());
        }

        if ($artworkSet->getCdArt() !== null) {
            $this->createArtwork($album, ArtworkInterface::TYPE_CDART, $artworkSet->getCdArt());
        }
    }

    /**
     * @param ArtworkCollectionInterface $artworkCollectionEntity
     * @param string $type
     * @param array $artworks
     */
    protected function createArtwork(
        ArtworkCollectionInterface $artworkCollectionEntity,
        string $type,
        $artworks = null
    ) {
        if ($artworks !== null) {
            foreach ($artworks as $artwork) {
                if (is_array($artwork)) {
                    $this->createArtwork($artworkCollectionEntity, $type, $artwork);
                }
                if (is_object($artwork)) {
                    $media = $this->getArtworkEntity($artworkCollectionEntity, $type);
                    $media->setLikes($artwork->likes);
                    $this->copyExternalFile($media, $artwork->url, $artworkCollectionEntity->getSlug() . '-' . $type);
                    if ($media->getImageName() !== null) {
                        $artworkCollectionEntity->addArtwork($media);
                    }
                }
            }
        }
    }

    /**
     * @param ArtworkCollectionInterface $artworkCollectionEntity
     * @param string $type
     *
     * @return AlbumArtworkEntity|ArtistArtworkEntity
     */
    private function getArtworkEntity(ArtworkCollectionInterface $artworkCollectionEntity, $type)
    {
        if ($artworkCollectionEntity instanceof ArtistInterface) {
            return new ArtistArtworkEntity($type);
        }
        if ($artworkCollectionEntity instanceof AlbumInterface) {
            return new AlbumArtworkEntity($type);
        }
    }
}
