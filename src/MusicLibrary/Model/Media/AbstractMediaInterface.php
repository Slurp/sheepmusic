<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model\Media;

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
