<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Streamers\Transcoder;

class Inspector
{
    /**
     * @param string $file
     * @param string $ffprobe
     *
     * @return float
     */
    public static function getLength($file, $ffprobe = '/usr/local/bin/ffprobe')
    {
        // fallback ffprobe
        if (file_exists($ffprobe) === false && $ffprobe !== '/usr/local/bin/ffprobe') {
            $ffprobe = '/usr/local/bin/ffprobe';
        }
        if (file_exists($ffprobe) === false) {
            $ffprobe = '/usr/bin/ffprobe';
        }
        $json = static::probe($file, $ffprobe);
        if (isset($json->streams) && isset($json->streams[0])) {
            return $json->streams[0]->duration;
        }

        return 0.0;
    }

    /**
     * @param string $file
     * @param string $ffprobe
     *
     * @return mixed
     */
    protected static function probe($file, $ffprobe)
    {
        $file = escapeshellarg($file);
        $cmd = $ffprobe . " -v quiet -print_format json -show_format -show_streams {$file}";
        exec($cmd, $outputLines);

        return json_decode(implode("\n", $outputLines));
    }
}
