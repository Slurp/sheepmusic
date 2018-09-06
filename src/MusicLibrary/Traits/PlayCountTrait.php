<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Traits;

/**
 * Trait SongCollectionTrait.
 */
trait PlayCountTrait
{
    /**
     * @var int
     */
    protected $playCount;

    /**
     * @return void
     */
    public function updatePlayCount()
    {
        $this->setPlayCount($this->getPlayCount() + 1);
    }

    /**
     * @return int
     */
    public function getPlayCount(): int
    {
        if ($this->playCount !== null) {
            return $this->playCount;
        }

        return 0;
    }

    /**
     * @param int $playCount
     */
    public function setPlayCount($playCount)
    {
        $this->playCount = $playCount;
    }
}
