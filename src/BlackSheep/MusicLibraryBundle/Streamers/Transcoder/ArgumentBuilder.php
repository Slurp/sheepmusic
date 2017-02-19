<?php
namespace BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

/**
 * Interface ArgumentBuilder
 *
 * @package BlackSheep\MusicLibraryBundle\Streamers\Transcoder
 */
interface ArgumentBuilder
{
    /**
     * @param $path
     * @param $startTime
     */
    public static function getArguments($path, $startTime);
}
