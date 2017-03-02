<?php

namespace BlackSheep\MusicLibraryBundle\LastFm;

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
