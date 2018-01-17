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

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;

/**
 * Interface AlbumCoverInterface.
 */
interface AlbumCoverInterface extends FilesystemCoverInterface
{
    /**
     * Generate a cover from provided data.
     *
     * @param AlbumInterface $album
     * @param array          $cover The cover data in array format, extracted by getID3.
     *                              For example:
     *                              [
     *                              'data' => '<binary data>',
     *                              'image_mime' => 'image/png',
     *                              'image_width' => 512,
     *                              'image_height' => 512,
     *                              'imagetype' => 'PNG', // not always present
     *                              'picturetype' => 'Other',
     *                              'description' => '',
     *                              'datalength' => 7627,
     *                              ]
     *
     * @return string
     */
    public function generateCover(AlbumInterface $album, array $cover);
}
