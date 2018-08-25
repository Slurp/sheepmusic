<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\MusicBrainz;

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
