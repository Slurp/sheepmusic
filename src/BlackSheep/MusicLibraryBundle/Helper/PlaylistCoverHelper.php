<?php

namespace BlackSheep\MusicLibraryBundle\Helper;

use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;

/**
 * Generates a cover for a playlist.
 */
class PlaylistCoverHelper
{
    /**
     *
     */
    const COVER_DIRECTION_PRIORITY = 'columns';
    /**
     *
     */
    const COVER_GRID_NUMBER = 3;

    /**
     * @var int
     */
    protected $coverThumbWidth = 300;

    /**
     * @var int
     */
    protected $coverThumbHeight = 300;

    /**
     * @param PlaylistInterface $playlist
     *
     * @param bool $useCache
     *
     * @return string
     */
    public function createCoverForPlaylist(PlaylistInterface $playlist, $useCache = true)
    {
        $fileName = $this->getUploadRootDirectory() . $playlist->getName() . '.jpg';
        if (file_exists($fileName) === false && $useCache === true) {
            $covers = $this->collectAllAlbumCovers($playlist);
            $numberOfCovers = count($covers);

            $columns = min(static::COVER_GRID_NUMBER, $numberOfCovers);
            $rows = (int) max(($numberOfCovers / $columns), 1);
            if (static::COVER_DIRECTION_PRIORITY == "rows") {
                $rows = $columns;
                $columns = (int) max(($numberOfCovers / $rows), 1);
            }
            $cover = $this->getBackground($rows, $columns);
            $this->mergeCovers($cover, $this->getImageObjects($covers, $rows, $columns), $rows, $columns);

            imagejpeg($cover, $fileName);
            imagedestroy($cover);
        }

        return $this->getUploadDirectory() . $playlist->getName() . '.jpg';
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
        return __DIR__ . '/../../../../web';
    }

    /**
     * @return string
     */
    public function getUploadDirectory()
    {
        return '/uploads/playlist/';
    }

    /**
     * @param PlaylistInterface $playlist
     *
     * @return array
     */
    protected function collectAllAlbumCovers(PlaylistInterface $playlist)
    {
        $covers = [];
        foreach ($playlist->getAlbums() as $album) {
            $cover = $album->getCover();
            if (strpos($cover, 'http') !== 0 && $cover !== null) {
                $cover = $album->getWebDirectory() . $cover;
            }
            $covers[] = $cover;
        }

        return $covers;
    }

    /**
     * @param $rows
     * @param $columns
     *
     * @return resource
     */
    protected function getBackground($rows, $columns)
    {
        $bgWidth = (int) $this->coverThumbWidth * $columns;
        $bgHeight = (int) $this->coverThumbHeight * $rows;

        return imagecreatetruecolor($bgWidth, $bgHeight); // setting canvas size
    }

    /**
     * @param $covers
     * @param $rows
     * @param $columns
     *
     * @return array
     */
    protected function getImageObjects($covers, $rows, $columns)
    {
        // Creating image objects
        $coverObjects = [];
        for ($i = 0; $i < ($rows * $columns); $i++) {
            $coverObjects[$i] = imagescale(
                imagecreatefromstring(file_get_contents($covers[$i])),
                $this->coverThumbWidth,
                $this->coverThumbHeight
            );
        }

        return $coverObjects;
    }

    /**
     * @param $background
     * @param $covers
     * @param $rows
     * @param $columns
     */
    protected function mergeCovers(&$background, $covers, $rows, $columns)
    {
        // Merge Images
        $step = 0;
        for ($x = 0; $x < $columns; $x++) {
            for ($y = 0; $y < $rows; $y++) {
                imagecopymerge(
                    $background,
                    $covers[$step],
                    ($this->coverThumbWidth * $x),
                    ($this->coverThumbHeight * $y),
                    0,
                    0,
                    $this->coverThumbWidth,
                    $this->coverThumbHeight,
                    100
                );
                $step++; // steps through the $coverObjects array
            }
        }
    }
}
