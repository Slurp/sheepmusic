<?php
namespace BlackSheep\MusicLibraryBundle\Helper;

/**
 * Interface FilesystemCoverInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Helper
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
