<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\LastFm;

use BlackSheep\MusicLibrary\MusicBrainz\MusicBrainzModelInterface;

/**
 * Solid FM.
 */
interface LastFmInterface extends MusicBrainzModelInterface
{
    /**
     * @return array
     */
    public function getLastFmInfoQuery();
}
