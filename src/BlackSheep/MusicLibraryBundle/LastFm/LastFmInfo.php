<?php
namespace BlackSheep\MusicLibraryBundle\LastFm;

/**
 * Interface LastFmInfo
 *
 * @package BlackSheep\MusicLibraryBundle\LastFm
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