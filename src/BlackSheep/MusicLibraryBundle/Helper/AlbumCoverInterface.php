<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 01/05/17
 * Time: 22:35
 * @copyright 2017 Bureau Blauwgeel
 * @version 1.0
 */

namespace BlackSheep\MusicLibraryBundle\Helper;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;

/**
 * Interface AlbumCoverInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Helper
 */
interface AlbumCoverInterface extends FilesystemCoverInterface
{
    /**
     * Generate a cover from provided data.
     *
     * @param AlbumInterface $album
     * @param array $cover The cover data in array format, extracted by getID3.
     *                     For example:
     *                     [
     *                     'data' => '<binary data>',
     *                     'image_mime' => 'image/png',
     *                     'image_width' => 512,
     *                     'image_height' => 512,
     *                     'imagetype' => 'PNG', // not always present
     *                     'picturetype' => 'Other',
     *                     'description' => '',
     *                     'datalength' => 7627,
     *                     ]
     *
     * @return string
     */
    public function generateCover(AlbumInterface $album, array $cover);
}
