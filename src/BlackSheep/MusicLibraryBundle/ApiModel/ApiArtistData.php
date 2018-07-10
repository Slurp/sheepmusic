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
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\SimilarArtist\SimilarArtistsInterface;

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
            $artistData = array_merge(
                $artistData,
                ApiArtworkHelper::prefixArtworkSetWithUrl(
                    $object,
                    $this->uploaderHelper,
                    $this->baseUrl
                )
            );
            $albumArt = $object->getAlbumArt();
            if (empty($albumArt) === false &&
                mb_strpos($albumArt, 'http') !== 0
            ) {
                $albumArt = $this->baseUrl . $albumArt;
            }

            return array_merge(
                [
                    'id' => $object->getId(),
                    'slug' => $object->getSlug(),
                    'createdAt' => $object->getCreatedAt(),
                    'updatedAt' => $object->getUpdatedAt(),
                    'image' => $object->getImage(),
                    'albumArt' => $albumArt,
                    'biography' => $object->getBiography(),
                    'albums' => $this->getAlbums($object),
                    'genres' => $this->getGenres($object),
                    'similar' => $this->getSimilar($object)
                ],
                $artistData
            );
        }

        return null;
    }

    /**
     * @param ArtistInterface $artist
     *
     * @return array
     */
    protected function getAlbums(ArtistInterface $artist): array
    {
        $albums = [];
        foreach ($artist->getAlbums() as $album) {
            $year = '0001';
            if ($album->getSongs()->first()) {
                $year = $album->getSongs()->first()->getYear();
            }
            $albums[] = ['id' => $album->getId(), 'year' => $year];
        }

        return $albums;
    }

    /**
     * @param ArtistInterface $artist
     *
     * @return array
     */
    protected function getGenres(ArtistInterface $artist): array
    {
        $genres = [];
        foreach ($artist->getGenres() as $genre) {
            $genres[] = $genre->getApiData();
        }

        return $genres;
    }

    /**
     * @param ArtistInterface $artist
     *
     * @return array
     */
    protected function getSimilar(ArtistInterface $artist): array
    {
        if (count($artist->getSimilarArtists()) > 0) {
            return array_slice(
                array_map(
                    function (SimilarArtistsInterface $artist) {
                        return $artist->getSimilar()->getId();
                    },
                    $artist->getSimilarArtists()->toArray()
                ),
                0,
                12
            );
        }

        return [];
    }
}
