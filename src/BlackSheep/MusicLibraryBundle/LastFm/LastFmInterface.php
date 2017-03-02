<?php
namespace BlackSheep\MusicLibraryBundle\LastFm;

use BlackSheep\MusicLibraryBundle\MusicBrainz\MusicBrainzModelInterface;

/**
 * Solid FM
 */
interface LastFmInterface extends MusicBrainzModelInterface
{
    /**
     * @return array
     */
    public function getLastFmInfoQuery();
}
