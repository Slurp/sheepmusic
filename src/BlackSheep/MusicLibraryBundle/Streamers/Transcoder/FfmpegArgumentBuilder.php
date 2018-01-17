<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

/**
 * Class  FfmpegArgumentBuilder.
 */
class FfmpegArgumentBuilder
{
    /**
     * @param $path
     * @param int $startTime
     *
     * @return string
     */
    public static function getArguments($path, $startTime, $bitRate)
    {
        $args = [
            '-i ' . escapeshellarg($path),
            '-map 0:0',
            '-v 0',
            "-b:a {$bitRate}k",
            '-f mp3',
            '-map_metadata -1',
            '- 2>/dev/null',
        ];

        if ($startTime) {
            $startTime = escapeshellarg($startTime);
            array_unshift($args, "-ss {$startTime}");
        }

        return implode(' ', $args);
    }
}
