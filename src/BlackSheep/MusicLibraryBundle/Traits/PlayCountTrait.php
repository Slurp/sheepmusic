<?php

namespace BlackSheep\MusicLibraryBundle\Traits;

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
     * @return $this
     */
    public function updatePlayCount()
    {
        $this->setPlayCount($this->getPlayCount() + 1);

        return $this;
    }

    /**
     * @return int
     */
    public function getPlayCount()
    {
        if ($this->playCount !== null) {
            return $this->playCount;
        }

        return 0;
    }

    /**
     * @param $playCount
     *
     * @return $this
     */
    public function setPlayCount($playCount)
    {
        $this->playCount = $playCount;

        return $this;
    }
}
