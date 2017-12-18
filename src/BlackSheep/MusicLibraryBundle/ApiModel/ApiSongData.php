<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;

/**
 * Generates a array for the API.
 */
class ApiSongData extends AbstractApiData implements ApiDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function getApiData($object)
    {
        if ($object instanceof SongEntity) {
            $apiData = $object->getApiData();
            $apiData['src'] = $this->router->generate('song_play', ['song' => $object->getId()]);
            $apiData['events'] =
                [
                    'now_playing' => $this->router->generate('post_announce_song', ['song' => $object->getId()]),
                    'played' => $this->router->generate('post_played_song', ['song' => $object->getId()])
                ];
            return $apiData;
        }

        return null;
    }
}
