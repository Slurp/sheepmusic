<?php

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
