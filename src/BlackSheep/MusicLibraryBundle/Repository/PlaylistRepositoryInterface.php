<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;

/**
 * Interface AlbumsRepositoryInterface.
 */
interface PlaylistRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param $name
     *
     * @return PlaylistInterface
     */
    public function getByName($name);
}
