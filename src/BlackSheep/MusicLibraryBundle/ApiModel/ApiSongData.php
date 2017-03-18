<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
use BlackSheep\MusicLibraryBundle\Model\ApiInterface;

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
            $apiData = [
                'track' => $object->getTrack(),
                'title' => $object->getTitle(),
                'src' => $this->router->generate('song_play', ['song' => $object->getId()]),
                'events' =>
                    [
                        'now_playing' => $this->router->generate('post_announce_song', ['song' => $object->getId()]),
                        'played' => $this->router->generate('post_played_song', ['song' => $object->getId()])
                    ]
            ];
            if ($object->getArtist() instanceof ApiInterface) {
                $apiData['artist'] = $object->getArtist()->getApiData();
            }
            if ($object->getAlbum() instanceof ApiInterface) {
                $apiData['album'] = $object->getAlbum()->getApiData();
            }

            return $apiData;
        }

        return null;
    }
}
