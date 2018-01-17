<?php

namespace BlackSheep\MusicLibraryBundle\Model\Media;

/**
 * Class AbstractMediaClass.
 */
interface AbstractMediaInterface
{
    /**
     * @param $imageName
     * @return void
     */
    public function setImageName($imageName);

    /**
     * @return string
     */
    public function getImageName();

    /**
     * @param $imageSize
     * @return void
     */
    public function setImageSize($imageSize);

    /**
     * @return int
     */
    public function getImageSize();
}
