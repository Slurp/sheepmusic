<?php

namespace BlackSheep\MusicLibraryBundle\Model\Media;

/**
 * Class AbstractMediaClass.
 */
interface AbstractMediaInterface
{
    /**
     * @param $imageName
     */
    public function setImageName($imageName);

    /**
     * @return string
     */
    public function getImageName();

    /**
     * @param $imageSize
     */
    public function setImageSize($imageSize);

    /**
     * @return int
     */
    public function getImageSize();
}
