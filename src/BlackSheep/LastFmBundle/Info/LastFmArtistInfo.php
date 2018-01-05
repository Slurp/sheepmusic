<?php

namespace BlackSheep\LastFmBundle\Info;

use LastFmApi\Api\ArtistApi;
use LastFmApi\Exception\InvalidArgumentException;

/**
 * Class LastFmArtistInfo.
 */
class LastFmArtistInfo extends AbstractLastFmInfo implements LastFmInfo
{
    /**
     * @return ArtistApi
     */
    protected function getApi()
    {
        return new ArtistApi($this->getAuth());
    }

    /**
     * @param $mdid
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
