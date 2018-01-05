<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 12/05/17
 * Time: 01:00
 *
 * @copyright 2017 Bureau Blauwgeel
 *
 * @version 1.0
 */

namespace BlackSheep\MusicLibraryBundle\User;

interface UserSettingsInterface
{
    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path);

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Set lastImport.
     *
     * @param \DateTime $lastImport
     *
     * @return $this
     */
    public function setLastImport($lastImport);

    /**
     * Get lastImport.
     *
     * @return \DateTime
     */
    public function getLastImport();
}
