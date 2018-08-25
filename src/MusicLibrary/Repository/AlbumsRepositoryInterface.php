<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Repository;

use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Model\ArtistInterface;

/**
 * Interface AlbumsRepositoryInterface.
 */
interface AlbumsRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param ArtistInterface $artists
     * @param                 $albumName
     * @param                 $extraInfo
     *
     * @return AlbumInterface|null
     */
    public function addOrUpdateByArtistAndName(ArtistInterface $artists, $albumName, $extraInfo);

    /**
     * @param ArtistInterface $artist
     * @param                 $albumName
     *
     * @return null|AlbumInterface
     */
    public function getArtistAlbumByName(ArtistInterface $artist, $albumName);

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getRecentAlbums();
}
