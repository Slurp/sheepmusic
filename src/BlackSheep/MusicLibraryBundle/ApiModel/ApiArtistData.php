<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

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
            $logos = [];
            if (count($object->getLogos()) > 0) {
                $baseUrl = '//' . $this->router->getContext()->getHost();
                foreach ($object->getLogos() as $logo) {
                    $logos[] = $baseUrl . $this->uploaderHelper->asset(
                            $logo,
                            'imageFile'
                        );
                }
            }

            return array_merge(
                [
                    'id' => $object->getId(),
                    'slug' => $object->getSlug(),
                    'createdAt' => $object->getCreatedAt(),
                    'updatedAt' => $object->getUpdatedAt(),
                    'albums' => $albums,
                    'logos' => $logos
                ],
                $artistData
            );
        }

        return null;
    }
}
