<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Entity\GenreEntity;

/**
 * Generates a array for the API.
 */
class ApiGenreData extends AbstractApiData implements ApiDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function getApiData($object)
    {
        if ($object instanceof GenreEntity) {
            $apiData = $object->getApiData();

            return $apiData;
        }

        return null;
    }
}
