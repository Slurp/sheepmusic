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

use BlackSheep\MusicLibraryBundle\Model\PlaylistInterface;

/**
 * Generates a cover for a playlist.
 */
class PlaylistCoverHelper extends AbstractUploadHelper
{
    const COVER_DIRECTION_PRIORITY = 'columns';
    const COVER_GRID_NUMBER        = 3;

    /**
     * @var int
     */
    protected $coverMaxWidth = 900;

    /**
     * @var int
     */
    protected $coverMaxHeight = 900;

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
     * @param bool $useCache
     *
     * @return string
     */
    public function createCoverForPlaylist(PlaylistInterface $playlist, $useCache = true)
    {
        $fileName = $this->getUploadRootDirectory() . $playlist->getName() . '.jpg';
        if (file_exists($fileName) === false || $useCache === false) {
            $covers = $this->collectAllAlbumCovers($playlist);
            $grid = $this->calculateColumnsAndRows($covers);
            $this->calculateThumbSize($grid['rows'], $grid['columns']);
            $background = $this->getBackground($grid['rows'], $grid['columns']);
            $this->mergeCovers(
                $background,
                $this->getImageObjects($covers, $grid['rows'], $grid['columns']),
                $grid['rows'],
                $grid['columns']
            );

            imagejpeg($background, $fileName);
            imagedestroy($background);
        }

        return static::getUploadDirectory() . $playlist->getName() . '.jpg';
    }

    /**
     * @param $covers
     *
     * @return array
     */
    public function calculateColumnsAndRows($covers)
    {
        $sqrRoot = sqrt(count($covers));
        $rows = $columns = round($sqrRoot, 0, PHP_ROUND_HALF_UP);
        if ($columns < $sqrRoot) {
            if (static::COVER_DIRECTION_PRIORITY === 'rows') {
                $columns += 1;
            } else {
                $rows += 1;
            }
        }
        return ['columns' => intval($columns), 'rows' => intval($rows)];
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
            if (mb_strpos($cover, 'http') !== 0 && $cover !== null) {
                $cover = $this->getWebDirectory() . $cover;
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
        $bgWidth = max((int) $this->coverThumbWidth * $columns, $this->coverMaxWidth);
        $bgHeight = max((int) $this->coverThumbHeight * $rows, $this->coverMaxHeight);

        return imagecreatetruecolor($bgWidth, $bgHeight); // setting canvas size
    }

    /**
     * @param $rows
     * @param $columns
     */
    protected function calculateThumbSize($rows, $columns)
    {
        if ($this->coverThumbWidth * $columns > $this->coverMaxWidth) {
            $this->coverThumbWidth = $this->coverMaxWidth / $columns;
        }
        if ($this->coverThumbHeight * $rows > $this->coverMaxHeight) {
            $this->coverThumbHeight = $this->coverMaxHeight / $rows;
        }
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
        for ($i = 0; $i < ($rows * $columns); ++$i) {
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
        for ($x = 0; $x < $columns; ++$x) {
            for ($y = 0; $y < $rows; ++$y) {
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
                ++$step; // steps through the $coverObjects array
            }
        }
    }

    /**
     * @return string
     */
    public static function getUploadDirectory()
    {
        return '/uploads/playlist/';
    }
}
