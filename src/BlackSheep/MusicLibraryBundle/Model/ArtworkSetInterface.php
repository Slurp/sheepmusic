<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Class ArtworkResponseInterface.
 */
interface ArtworkSetInterface
{
    /**
     * @return array
     */
    public function getLogos();

    /**
     * @return array
     */
    public function getBanners();

    /**
     * @return array
     */
    public function getBackgrounds();

    /**
     * @return array
     */
    public function getThumbs();
}
