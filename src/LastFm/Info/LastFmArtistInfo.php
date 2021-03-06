<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Info;

use BlackSheep\LastFm\Api\ArtistApi;
use LastFmApi\Exception\InvalidArgumentException;

/**
 * Class LastFmArtistInfo.
 */
class LastFmArtistInfo extends AbstractLastFmInfo implements LastFmInfo
{
    /**
     * @throws InvalidArgumentException
     *
     * @return ArtistApi
     */
    protected function getApi()
    {
        return new ArtistApi($this->getAuth());
    }

    /**
     * @param $mbid
     *
     * @return array
     */
    public function getSimilarByMusicBrainzId($mbid)
    {
        try {
            return $this->getApi()->getSimilar(['mbid' => $mbid]);
        } catch (InvalidArgumentException $connectionException) {
        }
    }
}
