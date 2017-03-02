<?php

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
