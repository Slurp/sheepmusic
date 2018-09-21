<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\Tests\MusicLibrary\Streamers\Transcoder;

use BlackSheep\MusicLibrary\Streamers\Transcoder\TranscodedSizeEstimator;
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
        self::assertSame(0.0, TranscodedSizeEstimator::estimatedBytes(0.0, 320));
        self::assertSame(24000000, TranscodedSizeEstimator::estimatedBytes(1000.0, 192));
        self::assertSame(40000000, TranscodedSizeEstimator::estimatedBytes(1000.0, 320));
        self::assertSame(22195672, TranscodedSizeEstimator::estimatedBytes(554.891791, 320));
    }
}
