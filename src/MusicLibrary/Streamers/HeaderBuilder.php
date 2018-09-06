<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Streamers;

/**
 *
 */
class HeaderBuilder
{
    /**
     * @param string $filename
     * @param float $size
     */
    public static function putHeader($filename, $size)
    {
        header('Cache-Control: public, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Accept-Ranges: bytes');
        header("Content-Length: {$size}");
        header('Content-type: audio/mpeg');
        header("Content-Disposition: inline; filename=\"{$filename}\"");
        header('Content-Transfer-Encoding: binary');
    }
}
