<?php
namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Model\ApiInterface;
use BlackSheep\MusicLibraryBundle\Model\Song;

/**
 * Generates a array for the API
 * @package BlackSheep\MusicLibraryBundle
 */
class ApiSongData extends AbstractApiData
{
    /**
     * @inheritdoc
     */
    public function getApiData($object)
    {
        if ($object instanceof Song) {
            $apiData = [
                'track' => $object->getTrack(),
                'title' => $object->getTitle(),
                'src' => $this->router->generate('song_play', ['song' => $object->getId()])
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
