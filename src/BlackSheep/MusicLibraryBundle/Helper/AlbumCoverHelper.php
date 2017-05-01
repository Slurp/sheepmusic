<?php

namespace BlackSheep\MusicLibraryBundle\Helper;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 *
 */
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
     * @param AlbumInterface $album
     * @param $extension
     *
     * @return string
     */
    protected function getFilename(AlbumInterface $album, $extension)
    {
        $extension = trim(strtolower($extension), '. ');

        return $album->getSlug() . ".$extension";
    }

    /**
     * Write a cover image file with binary data and update the Album with the new cover file.
     *
     * @param AlbumInterface $album
     * @param string $binaryData
     * @param string $filename
     *
     * @return string
     */
    protected function writeCoverFile(AlbumInterface $album, $binaryData, $filename)
    {
        $fs = new Filesystem();
        $fs->dumpFile(
            $this->getUploadRootDirectory() . $album->getArtist()->getSlug() . '/' . $filename,
            $binaryData
        );
        unset($fs);

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
