<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model;

use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;
use Gedmo\Sluggable\Sluggable;

/**
 * Interface ArtworkCollectionInterface.
 */
interface ArtworkCollectionInterface extends Sluggable
{
    /**
     * @return ArtworkInterface[]
     */
    public function getArtworks();

    /**
     * @param ArtworkInterface[] $artworks
     *
     * @return AlbumInterface
     */
    public function setArtworks($artworks);

    /**
     * @param ArtworkInterface $artwork
     *
     * @return AlbumInterface
     */
    public function addArtwork(ArtworkInterface $artwork);

    /**
     * @param ArtworkInterface $artwork
     *
     * @return $this
     */
    public function removeArtwork(ArtworkInterface $artwork);

    /**
     * @param string $type
     *
     * @return array|ArtworkInterface[]
     */
    public function filterArtwork($type);
}
