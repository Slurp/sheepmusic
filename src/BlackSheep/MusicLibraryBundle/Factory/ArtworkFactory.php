<?php

namespace BlackSheep\MusicLibraryBundle\Factory;

use BlackSheep\MusicLibraryBundle\Entity\Media\ArtworkEntity;
use BlackSheep\MusicLibraryBundle\Factory\Media\AbstractMediaFactory;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtworkSetInterface;
use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;

/**
 * Class ArtworkFactory
 *
 * @package BlackSheep\MusicLibraryBundle\Factory
 */
class ArtworkFactory extends AbstractMediaFactory
{
    /**
     * @param ArtistInterface $artist
     * @param ArtworkSetInterface $artworkSet
     */
    public function addArtworkToArtist(ArtistInterface $artist, ArtworkSetInterface $artworkSet)
    {
        if ($artworkSet->getLogos() !== null) {
            $this->createArtwork($artist, $artworkSet->getLogos(), ArtworkInterface::TYPE_LOGO);
        }
        if ($artworkSet->getBackgrounds() !== null) {
            $this->createArtwork($artist, $artworkSet->getBackgrounds(), ArtworkInterface::TYPE_BACKGROUND);
        }
        if ($artworkSet->getBanners() !== null) {
            $this->createArtwork($artist, $artworkSet->getBanners(), ArtworkInterface::TYPE_BANNER);
        }
        if ($artworkSet->getThumbs() !== null) {
            $this->createArtwork($artist, $artworkSet->getThumbs(), ArtworkInterface::TYPE_THUMBS);
        }
    }

    /**
     * @param ArtistInterface $artist
     * @param array $artworks
     * @param $type
     */
    protected function createArtwork(ArtistInterface $artist, $artworks, $type)
    {
        foreach ($artworks as $artwork) {
            if (is_array($artwork)) {
                $this->createArtwork($artist, $artwork, $type);
            }
            if (is_object($artwork)) {
                $media = new ArtworkEntity($type);
                $media->setLikes($artwork->likes);
                $this->copyExternalFile($media, $artwork->url, $artist->getSlug() . '-'.$type);
                $artist->addArtwork($media);
            }
        }
    }
}
