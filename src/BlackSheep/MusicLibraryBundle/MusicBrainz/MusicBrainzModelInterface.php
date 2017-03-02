<?php

namespace BlackSheep\MusicLibraryBundle\MusicBrainz;

/**
 * Interface MusicBrainzModelInterface.
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
