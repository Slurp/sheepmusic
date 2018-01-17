<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;

/**
 * You can't see me.
 */
interface LastFmAlbumInterface extends LastFmInterface
{
    /**
     * @param AlbumInterface $album
     */
    public function updateLastFmInfo(AlbumInterface $album);
}
