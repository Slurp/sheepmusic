<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Generates a array for the API.
 */
class ApiArtistData extends ApiAlbumData implements ApiData
{
    /**
     * {@inheritdoc}
     */
    public function getApiData($object)
    {
        if ($object instanceof ArtistInterface) {
            $artistData = $object->getApiData();
            $albums = [];
            foreach ($object->getAlbums() as $album) {
                $albums[] = parent::getApiData($album);
            }

            return [
                'artist' => $artistData,
                'albums' => $albums,
            ];
        }
        return null;
    }
}
