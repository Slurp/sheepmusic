<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Factory;

use BlackSheep\FanartTv\Model\FanartTvResponse;
use BlackSheep\MusicLibrary\Entity\Media\AlbumArtworkEntity;
use BlackSheep\MusicLibrary\Entity\Media\ArtistArtworkEntity;
use BlackSheep\MusicLibrary\Factory\Media\AbstractMediaFactory;
use BlackSheep\MusicLibrary\Model\AlbumArtworkSetInterface;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Model\ArtworkCollectionInterface;
use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;

/**
 * Class ArtworkFactory.
 */
class ArtworkFactory extends AbstractMediaFactory
{
    /**
     * @param ArtistInterface  $artist
     * @param FanartTvResponse $artworkSet
     */
    public function addArtworkToArtist(ArtistInterface $artist, FanartTvResponse $artworkSet)
    {
        if (\count($artist->getArtworks()) === 0) {
            $this->createArtwork($artist, ArtworkInterface::TYPE_LOGO, $artworkSet->getLogos());
            $this->createArtwork($artist, ArtworkInterface::TYPE_BACKGROUND, $artworkSet->getBackgrounds());
            $this->createArtwork($artist, ArtworkInterface::TYPE_BANNER, $artworkSet->getBanners());
            $this->createArtwork($artist, ArtworkInterface::TYPE_THUMBS, $artworkSet->getThumbs());
        }
        $this->updateAlbumsForArtist($artist, $artworkSet);
    }

    /**
     * @param ArtistInterface  $artist
     * @param FanartTvResponse $artworkSet
     */
    protected function updateAlbumsForArtist(ArtistInterface $artist, FanartTvResponse $artworkSet)
    {
        if ($artworkSet->getArtworkCover() !== null || $artworkSet->getCdArt() !== null) {
            foreach ($artist->getAlbums() as $album) {
                if ($album->getMusicBrainzId() !== null) {
                    if (isset($artworkSet->getArtworkCover()[$album->getMusicBrainzReleaseGroupId()]) &&
                        \count($album->getArtworkCover()) === 0
                    ) {
                        $this->createArtwork(
                            $album,
                            ArtworkInterface::TYPE_COVER,
                            $artworkSet->getArtworkCover()[$album->getMusicBrainzReleaseGroupId()]
                        );
                    }
                    if (isset($artworkSet->getCdArt()[$album->getMusicBrainzReleaseGroupId()]) &&
                        \count($album->getCdArt()) === 0
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
     * @param AlbumInterface           $album
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
     * @param ArtworkCollectionInterface $artworkCollection
     * @param string                     $type
     * @param array                      $artworks
     */
    protected function createArtwork(
        ArtworkCollectionInterface $artworkCollection,
        string $type,
        $artworks = null
    ) {
        if ($artworks !== null) {
            foreach ($artworks as $artwork) {
                if (\is_array($artwork)) {
                    $this->createArtwork($artworkCollection, $type, $artwork);
                }
                if (\is_object($artwork)) {
                    $media = $this->getArtworkEntity($artworkCollection, $type);
                    $media->setLikes($artwork->likes);
                    $this->copyExternalFile($media, $artwork->url, $artworkCollection->getSlug() . '-' . $type);
                    if ($media->getImageFile() !== null) {
                        $artworkCollection->addArtwork($media);
                    }
                }
            }
        }
    }

    /**
     * @param ArtworkCollectionInterface $artworkCollection
     * @param string                     $type
     *
     * @return AlbumArtworkEntity|ArtistArtworkEntity
     */
    private function getArtworkEntity(ArtworkCollectionInterface $artworkCollection, $type)
    {
        $new = null;
        if ($artworkCollection instanceof ArtistInterface) {
            $new = new ArtistArtworkEntity($type);
            $new->setArtist($artworkCollection);
        }
        if ($artworkCollection instanceof AlbumInterface) {
            $new = new AlbumArtworkEntity($type);
            $new->setAlbum($artworkCollection);
        }

        return $new;
    }
}
