<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity\Media;

use BlackSheep\MusicLibrary\Model\AlbumInterface;

/**
 * Interface AlbumArtworkEntityInterface.
 */
interface AlbumArtworkEntityInterface
{
    /**
     * @return AlbumInterface
     */
    public function getAlbum(): AlbumInterface;

    /**
     * @param AlbumInterface $album
     */
    public function setAlbum(AlbumInterface $album);
}
