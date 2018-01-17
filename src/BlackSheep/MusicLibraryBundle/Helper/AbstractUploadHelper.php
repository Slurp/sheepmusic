<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Helper;

/**
 * Give a class a nudge to help with uploading of files.
 */
abstract class AbstractUploadHelper implements FilesystemCoverInterface
{
    /**
     * @var string
     */
    protected $webDirectory;

    /**
     * @param string|null $webDirectory
     */
    public function __construct($webDirectory = null)
    {
        $this->webDirectory = $webDirectory;
        if ($this->webDirectory === null) {
            $this->webDirectory = __DIR__ . '/../../../../web';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadRootDirectory()
    {
        return $this->getWebDirectory() . $this->getUploadDirectory();
    }

    /**
     * @return string
     */
    public function getWebDirectory()
    {
        return $this->webDirectory;
    }

    /**
     * @return string
     */
    abstract public static function getUploadDirectory();
}
