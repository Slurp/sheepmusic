<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Class ArtworkResponseInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Model
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
