<?php
namespace BlackSheep\MusicLibraryBundle\MusicBrainz;

/**
 * Interface MusicBrainzModelInterface
 *
 * @package BlackSheep\MusicLibraryBundle\MusicBrainz
 */
interface MusicBrainzModelInterface
{
    /**
     * @return mixed
     */
    public function getMusicBrainzId();

    /**
     * @param $musicBrainzId
     *
     * @return mixed
     */
    public function setMusicBrainzId($musicBrainzId);
}