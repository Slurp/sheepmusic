<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface PlayCountInterface.
 */
interface PlayCountInterface
{
    /**
     * @return $this
     */
    public function updatePlayCount();

    /**
     * @return int
     */
    public function getPlayCount();

    /**
     * @param int $playCount
     *
     * @return PlayCountInterface
     */
    public function setPlayCount($playCount);
}
