<?php

namespace BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

class Inspector
{
    /**
     * @param $file
     *
     * @return float
     */
    public static function getLength($file)
    {
        $json = static::probe($file);
        if (isset($json->streams) && isset($json->streams[0])) {
            return $json->streams[0]->duration;
        }

        return 0.0;
    }

    /**
     * @param $file
     *
     * @return mixed
     */
    protected static function probe($file)
    {
        $file = escapeshellarg($file);
        $cmd = "/usr/local/bin/ffprobe -v quiet -print_format json -show_format -show_streams {$file}";
        exec($cmd, $outputLines);
        $json = implode("\n", $outputLines);

        return json_decode($json);
    }
}
