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

use BlackSheep\MusicLibrary\Entity\ArtistsEntity;
use BlackSheep\MusicLibrary\Model\ArtistInterface;

/**
 * Interface ArtistRepositoryInterface.
 */
interface ArtistRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $artistName
     * @param null $musicBrainzId
     *
     * @return ArtistsEntity|null
     */
    public function addOrUpdate($artistName, $musicBrainzId = null);

    /**
     * @param string $artistName
     *
     * @return ArtistInterface|null
     */
    public function getArtistByName($artistName);

    /**
     * @param string|null $musicBrainzId
     *
     * @return ArtistInterface|null
     */
    public function getArtistByMusicBrainzId($musicBrainzId = null);

    /**
     * @param  ArtistInterface $artist
     * @param  string $albumName
     *
     * @return object|null
     */
    public function getArtistAlbumByName($artist, $albumName);
}
