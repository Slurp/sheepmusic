<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFmBundle\Info;

use BlackSheep\MusicLibraryBundle\LastFm\LastFmInterface;

/**
 * Interface LastFmInfo.
 */
interface LastFmInfo
{
    /**
     * @param LastFmInterface $lastFmInterface
     *
     * @return array
     */
    public function getInfo(LastFmInterface $lastFmInterface);
}
