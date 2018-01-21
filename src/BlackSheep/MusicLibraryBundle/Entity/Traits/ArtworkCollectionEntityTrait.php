<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 22/01/2018
 * Time: 00:29
 */

namespace BlackSheep\MusicLibraryBundle\Entity\Traits;

use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;

/**
 * Class ArtworkCollectionEntityTrait
 *
 * @package BlackSheep\MusicLibraryBundle\Entity\Traits
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
            function (ArtworkInterface $artwork) use ($type) {
                return $artwork->getType() === $type;
            }
        );
    }
}
