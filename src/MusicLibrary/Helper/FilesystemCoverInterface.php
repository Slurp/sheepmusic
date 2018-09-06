<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Helper;

/**
 * Interface FilesystemCoverInterface.
 */
interface FilesystemCoverInterface
{
    /**
     * @param string|null $webDirectory
     */
    public function __construct($webDirectory = null);

    /**
     * @return string
     */
    public function getUploadRootDirectory();

    /**
     * @return string
     */
    public function getWebDirectory();

    /**
     * @return string
     */
    public static function getUploadDirectory();
}
