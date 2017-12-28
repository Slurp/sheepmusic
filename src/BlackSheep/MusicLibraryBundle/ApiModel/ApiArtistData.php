<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\ApiModel\Helper\ApiArtworkHelper;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Generates a array for the API.
 */
class ApiArtistData extends ApiAlbumData implements ApiDataInterface
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
            $genres = [];
            foreach ($object->getGenres() as $genre) {
                $genres[] = $genre->getApiData();
            }

            $artistData = array_merge(
                $artistData,
                ApiArtworkHelper::prefixArtworkSetWithUrl(
                    $object,
                    $this->uploaderHelper,
                    '//' . $this->router->getContext()->getHost()
                )
            );

            return array_merge(
                [
                    'id' => $object->getId(),
                    'slug' => $object->getSlug(),
                    'createdAt' => $object->getCreatedAt(),
                    'updatedAt' => $object->getUpdatedAt(),
                    'albums' => $albums,
                    'genres' => $genres
                ],
                $artistData
            );
        }

        return null;
    }
}
