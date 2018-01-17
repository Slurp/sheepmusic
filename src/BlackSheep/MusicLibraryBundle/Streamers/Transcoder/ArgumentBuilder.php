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
