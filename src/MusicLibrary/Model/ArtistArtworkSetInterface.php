<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model;

/**
 * Class ArtistArtworkSetInterface.
 */
interface ArtistArtworkSetInterface
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
