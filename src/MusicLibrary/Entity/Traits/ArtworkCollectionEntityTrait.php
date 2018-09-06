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

use BlackSheep\MusicLibrary\Model\Media\ArtworkInterface;

/**
 * Class ArtworkCollectionEntityTrait.
 */
trait ArtworkCollectionEntityTrait
{
    /**
     * @param $type
     *
     * @return array|ArtworkInterface[]
     */
    protected function filterArtwork($type)
    {
        return array_filter(
            $this->artworks->toArray(),
            function(ArtworkInterface $artwork) use ($type) {
                return $artwork->getType() === $type;
            }
        );
    }
}
