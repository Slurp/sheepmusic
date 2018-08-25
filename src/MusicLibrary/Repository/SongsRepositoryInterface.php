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

use BlackSheep\MusicLibrary\Entity\SongEntity;

/**
 * Interface SongsRepositoryInterface.
 */
interface SongsRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param $songInfo
     *
     * @return null|SongEntity
     */
    public function needsImporting($songInfo);

    /**
     * @return null|object
     */
    public function lastImportDate();
}
