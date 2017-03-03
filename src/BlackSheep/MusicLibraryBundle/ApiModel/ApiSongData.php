<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Model\ApiInterface;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;

/**
 * Generates a array for the API.
 */
class ApiSongData extends AbstractApiData implements ApiData
{
    /**
     * {@inheritdoc}
     */
    public function getApiData($object)
    {
        if ($object instanceof SongInterface) {
            $apiData = [
                'track' => $object->getTrack(),
                'title' => $object->getTitle(),
                'src' => $this->router->generate('song_play', ['song' => $object->getId()]),
                'events' => [
                        'played' => $this->router->generate('post_played_song', ['song' => $object->getId()]),
                    ],
            ];
            if ($object->getArtist() instanceof ApiInterface) {
                $apiData['artist'] = $object->getArtist()->getApiData();
            }
            if ($object->getAlbum() instanceof ApiInterface) {
                $apiData['album'] = $object->getAlbum()->getApiData();
            }

            return $apiData;
        }
    }
}
