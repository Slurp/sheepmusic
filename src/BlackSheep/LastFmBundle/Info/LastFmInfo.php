<?php

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
