<?php

namespace BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

class Inspector
{
    /**
     * @param $file
     * @param $ffprobe
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
     * @param $file
     * @param string $ffprobe
     *
     * @return mixed
     */
    protected static function probe($file, $ffprobe)
    {
        $file = escapeshellarg($file);
        $cmd = $ffprobe . " -v quiet -print_format json -show_format -show_streams {$file}";
        exec($cmd, $outputLines);
        $json = implode("\n", $outputLines);

        return json_decode($json);
    }
}
