<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

use BlackSheep\MusicLibraryBundle\Streamers\Transcoder\TranscodedSizeEstimator;
use PHPUnit\Framework\TestCase;

/**
 *TranscodedSizeEstimatorTest.
 */
class TranscodedSizeEstimatorTest extends TestCase
{
    protected function setUp()
    {
    }

    /**
     * testEstimatedBytes.
     */
    public function testEstimatedBytes()
    {
        self::assertEquals(0, TranscodedSizeEstimator::estimatedBytes(0.0, 320));
        self::assertEquals(24000000, TranscodedSizeEstimator::estimatedBytes(1000.0, 192));
        self::assertEquals(40000000, TranscodedSizeEstimator::estimatedBytes(1000.0, 320));
        self::assertEquals(22195672, TranscodedSizeEstimator::estimatedBytes(554.891791, 320));
    }
}
