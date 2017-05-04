<?php
namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface PlayCountInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Model
 */
interface PlayCountInterface
{
    /**
     * @return $this
     */
    public function updatePlayCount();

    /**
     * @return integer
     */
    public function getPlayCount();

    /**
     * @param integer $playCount
     *
     * @return PlayCountInterface
     */
    public function setPlayCount($playCount);
}
