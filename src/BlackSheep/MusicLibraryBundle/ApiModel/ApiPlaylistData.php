<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;
use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;

/**
 * Generates a array for the API.
 */
class ApiPlaylistData extends ApiSongData implements ApiDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function getApiData($object)
    {
        if ($object instanceof PlaylistEntity) {
            $songs = [];
            foreach ($object->getSongs() as $song) {
                $songs[] = parent::getApiData($song);
            }
            return array_merge(
                [
                    'songs' => $songs,
                ],
                $object->getApiData()
            );
        }
        return null;
    }
}
