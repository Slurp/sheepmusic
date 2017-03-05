<?php

namespace BlackSheep\LastFmBundle\Info;

use LastFmApi\Api\AlbumApi;

/**
 * Get the Correct API.
 */
class LastFmAlbumInfo extends AbstractLastFmInfo implements LastFmInfo
{
    /**
     * @return AlbumApi
     */
    protected function getApi()
    {
        return new AlbumApi($this->getAuth());
    }
}
