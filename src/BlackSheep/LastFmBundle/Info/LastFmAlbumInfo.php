<?php

namespace BlackSheep\LastFmBundle\Info;

use BlackSheep\LastFmBundle\Api\AlbumApi;

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
