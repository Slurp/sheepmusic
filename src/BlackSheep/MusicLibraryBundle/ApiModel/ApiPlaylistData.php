<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;

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
                $songs[$song->getPosition()] = parent::getApiData($song->getSong());
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
