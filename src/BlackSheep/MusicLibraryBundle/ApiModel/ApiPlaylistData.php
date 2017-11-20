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
                'id' => $object->getId(),
                'cover' => $object->getCover(),
                'name' => $object->getName(),
                'createdAt' => $object->getCreatedAt(),
                'updatedAt' => $object->getUpdatedAt(),
                'songs' => $songs,
            ];
        }
        return null;
    }
}
