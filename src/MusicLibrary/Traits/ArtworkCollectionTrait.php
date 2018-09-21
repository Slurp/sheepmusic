<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Traits;

use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;

/**
 * Trait ArtworkCollectionTrait.
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
     * @param ArtworkInterface[]
     */
    public function setArtworks($artworks)
    {
        $this->artworks = $artworks;
    }

    /**
     * @param ArtworkInterface $artwork
     */
    public function addArtwork(ArtworkInterface $artwork)
    {
        if (\in_array($artwork, $this->artworks, true) === false) {
            $this->artworks[] = $artwork;
        }
    }

    /**
     * @param ArtworkInterface $artwork
     */
    public function removeArtwork(ArtworkInterface $artwork)
    {
        if (($key = array_search($artwork, $this->artworks, true)) !== false) {
            unset($this->artworks[$key]);
            $this->artworks = array_values($this->artworks);
        }
    }

    /**
     * @param string $type
     *
     * @return array|ArtworkInterface[]
     */
    protected function filterArtwork($type)
    {
        if($this->artworks !== null) {
            return array_filter(
                $this->artworks,
                function (ArtworkInterface $artwork) use ($type) {
                    return $artwork->getType() === $type;
                }
            );
        }
        return [];
    }
}
