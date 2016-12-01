<?php
namespace BlackSheep\MusicLibraryBundle\LastFm;

use LastFmApi\Api\AlbumApi;

/**
 *
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
