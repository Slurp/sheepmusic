<?php
namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;

/**
 * Generates a array for the API
 * @package BlackSheep\MusicLibraryBundle
 */
class ApiAlbumData extends ApiSongData
{
    /**
     * @inheritdoc
     */
    public function getApiData($object)
    {
        if ($object instanceof AlbumInterface) {
            $albumData = $object->getApiData();
            $artistData = $object->getArtist()->getApiData();
            $songs = [];
            foreach ($object->getSongs() as $song) {
                $songs[] = parent::getApiData($song);
            }

            return [
                'album' => $albumData,
                'artist' => $artistData,
                'songs' => $songs
            ];
        }
    }
}
