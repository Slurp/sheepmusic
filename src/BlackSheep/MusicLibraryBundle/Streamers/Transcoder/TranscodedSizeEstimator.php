<?php

namespace BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

/**
 * How big is your transcode?
 */
class TranscodedSizeEstimator
{
    /**
     * @var int
     */
    const BITS_PER_BYTE = 8;

    /**
     * @param $length
     * @param int $kbps
     *
     * @return float
     */
    public static function estimatedBytes($length, $kbps)
    {
        return round(static::estimatedBits($length, $kbps) / static::BITS_PER_BYTE);
    }

    /**
     * @param $length
     * @param $kbps
     *
     * @return mixed
     */
    private static function estimatedBits($length, $kbps)
    {
        return $length * $kbps * 1000;
    }
}
