<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

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
        if ($object instanceof PlaylistInterface) {
            $songs = [];
            foreach ($object->getSongs() as $song) {
                $songs[] = parent::getApiData($song);
            }
            return [
                'name' => $object->getName(),
                'songs' => $songs,
            ];
        }
        return null;
    }
}
