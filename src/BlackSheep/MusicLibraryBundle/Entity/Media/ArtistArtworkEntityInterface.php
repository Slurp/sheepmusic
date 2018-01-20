<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Entity\Media;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Interface ArtistArtworkEntityInterface.
 */
interface ArtistArtworkEntityInterface
{
    /**
     * @return ArtistInterface
     */
    public function getArtist(): ArtistInterface;

    /**
     * @param ArtistInterface $artist
     */
    public function setArtist(ArtistInterface $artist);
}
