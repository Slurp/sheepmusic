<?php
namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\MusicLibraryBundle\MusicBrainz\MusicBrainzModelInterface;

/**
 *
 */
interface LastFmInterface extends MusicBrainzModelInterface
{
    /**
     * @return array
     */
    public function getLastFmInfoQuery();
}
