<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
