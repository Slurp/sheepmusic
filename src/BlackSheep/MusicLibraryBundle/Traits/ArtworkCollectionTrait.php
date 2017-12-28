<?php

namespace BlackSheep\MusicLibraryBundle\Traits;

use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;

/**
 * Trait ArtworkCollectionTrait
 *
 * @package BlackSheep\MusicLibraryBundle\Traits
 */
trait ArtworkCollectionTrait
{
    /**
     * @var ArtworkInterface[]
     */
    protected $artworks;

    /**
     * @return ArtworkInterface[]
     */
    public function getArtworks()
    {
        return $this->artworks;
    }

    /**
     * {@inheritdoc}
     */
    public function setArtworks($artworks)
    {
        $this->artworks = $artworks;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addArtwork(ArtworkInterface $artwork)
    {
        if (in_array($artwork, $this->artworks) === false) {
            $this->artworks[] = $artwork;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeArtwork(ArtworkInterface $artwork)
    {
        if (($key = array_search($artwork, $this->artworks, true)) !== false) {
            unset($this->artworks[$key]);
            $this->artworks = array_values($this->artworks);
        }

        return $this;
    }

    /**
     * @return array|ArtworkInterface[]
     */
    public function getLogos()
    {
        return $this->filterArtwork(ArtworkInterface::TYPE_LOGO);
    }

    /**
     * @return array|ArtworkInterface[]
     */
    public function getBanners()
    {
        return $this->filterArtwork(ArtworkInterface::TYPE_BANNER);
    }

    /**
     * @return array|ArtworkInterface[]
     */
    public function getBackgrounds()
    {
        return $this->filterArtwork(ArtworkInterface::TYPE_BACKGROUND);
    }

    /**
     * @return array|ArtworkInterface[]
     */
    public function getThumbs()
    {
        return $this->filterArtwork(ArtworkInterface::TYPE_THUMBS);
    }

    /**
     * @param $type
     *
     * @return array|ArtworkInterface[]
     */
    protected function filterArtwork($type)
    {
        return array_filter(
            $this->artworks,
            function (ArtworkInterface $artwork) use ($type) {
                return $artwork->getType() === $type;
            }
        );
    }
}
