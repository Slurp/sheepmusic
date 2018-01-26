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

            if (count($object->getArtworkCover()) !== 0) {
                $albumData['cover'] = $this->baseUrl .
                    $this->uploaderHelper->asset(
                        $object->getArtworkCover()[0],
                        'imageFile'
                    );
            }

            return array_merge(
                [
                    'id' => $object->getId(),
                    'slug' => $albumData['slug'],
                    'createdAt' => $object->getCreatedAt(),
                    'updatedAt' => $object->getUpdatedAt(),
                    'artist' => $object->getArtist()->getApiData(),
                    'songs' => $this->getSongs($object),
                    'genre' => $object->getGenre() ? $object->getGenre()->getApiData() : [],
                    'mbId' => $object->getMusicBrainzId(),
                    'lossless' => $object->isLossless(),
                ],
                $albumData
            );
        }

        return null;
    }

    /**
     * @param AlbumInterface $album
     *
     * @return array
     */
    protected function getSongs(AlbumInterface $album): array
    {
        $songs = [];
        foreach ($album->getSongs() as $song) {
            $songs[] = parent::getApiData($song);
        }

        return $songs;
    }
}
