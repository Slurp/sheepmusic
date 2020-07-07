<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity\Traits;

use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\Entity\ArtistsEntity;
use BlackSheep\MusicLibrary\Entity\Media\AlbumArtworkEntity;
use BlackSheep\MusicLibrary\Entity\Media\ArtistArtworkEntity;
use BlackSheep\MusicLibrary\Model\Album;
use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class ArtworkCollectionEntityTrait.
 */
trait ArtworkCollectionEntityTrait
{
    /**
     * @param ArtworkInterface $artwork
     */
    public function removeArtwork(ArtworkInterface $artwork)
    {
        if($this->artworks instanceof Collection && $this->artworks->contains($artwork)) {
            if($artwork instanceof AlbumArtworkEntity) {
                $artwork->setAlbum(null);
            }
            if($artwork instanceof ArtistArtworkEntity) {
                $artwork->setArtist(null);
            }
        }
    }

    /**
     * @param $type
     *
     * @return array|ArtworkInterface[]
     */
    public function filterArtwork($type)
    {
        return array_filter(
            $this->artworks->toArray(),
            function (ArtworkInterface $artwork) use ($type) {
                return $artwork->getType() === $type;
            }
        );
    }
}
