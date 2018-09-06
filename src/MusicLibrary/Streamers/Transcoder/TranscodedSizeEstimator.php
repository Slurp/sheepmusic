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
     * @param float $length
     * @param int   $kbps
     *
     * @return float
     */
    public static function estimatedBytes($length, $kbps)
    {
        return round(self::estimatedBits($length, $kbps) / static::BITS_PER_BYTE);
    }

    /**
     * @param float $length
     * @param int   $kbps
     *
     * @return float
     */
    private static function estimatedBits($length, $kbps)
    {
        return $length * $kbps * 1000;
    }
}
