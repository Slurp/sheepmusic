<?php

namespace BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

/**
 * Interface ArgumentBuilder.
 */
interface ArgumentBuilder
{
    /**
     * @param $path
     * @param $startTime
     */
    public static function getArguments($path, $startTime);
}
