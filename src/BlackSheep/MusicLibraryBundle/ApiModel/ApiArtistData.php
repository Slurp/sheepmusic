<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
                $year = '0001';
                if ($album->getSongs()->first()) {
                    $year = $album->getSongs()->first()->getYear();
                }
                $albums[] = ['id' => $album->getId(), 'year' => $year];
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
                ],
                $artistData
            );
        }

        return null;
    }
}
