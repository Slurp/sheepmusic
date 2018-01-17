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

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;

/**
 * Generates a array for the API.
 */
class ApiAlbumData extends ApiSongData implements ApiDataInterface
{
    /**
     * {@inheritdoc}
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

            return array_merge(
                [
                    'id' => $object->getId(),
                    'slug' => $albumData['slug'],
                    'createdAt' => $object->getCreatedAt(),
                    'updatedAt' => $object->getUpdatedAt(),
                    'artist' => $artistData,
                    'songs' => $songs,
                    'genre' => $object->getGenre() ? $object->getGenre()->getApiData() : [],
                ],
                $albumData
            );
        }

        return null;
    }
}
