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

use BlackSheep\MusicLibrary\Model\AlbumInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Filesystem\Filesystem;

class AlbumCoverHelper extends AbstractUploadHelper implements AlbumCoverInterface
{
    /**
     * {@inheritdoc}
     */
    public function generateCover(AlbumInterface $album, array $cover)
    {
        $extension = explode('/', $cover['image_mime']);
        $extension = empty($extension[1]) ? 'png' : $extension[1];
        $album->setCover($this->writeCoverFile($album, $cover['data'], $this->getFilename($album, $extension)));
    }

    /**
     * {@inheritdoc}
     */
    public function downloadCover(AlbumInterface $album, string $url)
    {
        $album->setCover(
            $this->writeCoverFile(
                $album,
                file_get_contents($url),
                $this->getFilename($album, mb_substr($url, mb_strrpos($url, '.') + 1))
            )
        );
    }

    /**
     * @param AlbumInterface $album
     * @param $extension
     *
     * @return string
     */
    protected function getFilename(AlbumInterface $album, $extension)
    {
        $extension = trim(mb_strtolower($extension), '. ');

        return Urlizer::urlize($album->getName()) . ".$extension";
    }

    /**
     * Write a cover image file with binary data and update the Album with the new cover file.
     *
     * @param AlbumInterface $album
     * @param string         $binaryData
     * @param string         $filename
     *
     * @return string
     */
    protected function writeCoverFile(AlbumInterface $album, $binaryData, $filename)
    {
        $systemName = $this->getUploadRootDirectory() . $album->getArtist()->getSlug() . '/cover-' . $filename;
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile(
            $systemName,
            $binaryData
        );
        unset($fileSystem, $binaryData);

        return $filename;
    }

    /**
     * @return string
     */
    public static function getUploadDirectory()
    {
        return '/uploads/artist/';
    }
}
