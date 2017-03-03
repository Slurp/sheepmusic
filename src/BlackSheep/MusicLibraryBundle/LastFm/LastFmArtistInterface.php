<?php

namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * You can't see me.
 */
interface LastFmArtistInterface extends LastFmInterface
{
    /**
     * @param ArtistInterface $artist
     */
    public function updateLastFmInfo(ArtistInterface $artist);
}
