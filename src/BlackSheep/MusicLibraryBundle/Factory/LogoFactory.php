<?php

namespace BlackSheep\MusicLibraryBundle\Factory;

use BlackSheep\MusicLibraryBundle\Entity\Media\LogoEntity;
use BlackSheep\MusicLibraryBundle\Factory\Media\AbstractMediaFactory;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Class LogoFactory
 *
 * @package BlackSheep\MusicLibraryBundle\Factory
 */
class LogoFactory extends AbstractMediaFactory
{
    /**
     * @param ArtistInterface $artist
     * @param array $logos
     */
    public function addLogosToArtist(ArtistInterface $artist, $logos)
    {
        foreach ($logos as $logo) {
            if (is_array($logo)) {
                $this->addLogosToArtist($artist, $logo);
            }
            if (is_object($logo)) {
                $media = new LogoEntity();
                $media->setLikes($logo->likes);
                $this->copyExternalFile($media, $logo->url, $artist->getSlug().'-logo');
                $artist->addLogo($media);
            }
        }
    }
}
