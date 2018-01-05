<?php

namespace BlackSheep\MusicLibraryBundle\Model\Media;

/**
 * Class AbstractMediaClass.
 */
abstract class AbstractMedia implements AbstractMediaInterface
{
    /**
     * @var mixed
     */
    protected $imageFile;

    /**
     * @var string
     */
    protected $imageName;

    /**
     * @var int
     */
    protected $imageSize;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @param $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param $imageSize
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;
    }

    /**
     * @return int
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }
}
