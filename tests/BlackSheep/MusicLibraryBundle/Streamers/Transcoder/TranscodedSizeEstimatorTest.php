<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 03/03/17
 * Time: 16:26
 * @copyright 2017 Bureau Blauwgeel
 * @version 1.0
 */
namespace Tests\BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

use BlackSheep\MusicLibraryBundle\Streamers\Transcoder\TranscodedSizeEstimator;
use PHPUnit_Framework_TestCase;

/**
 *TranscodedSizeEstimatorTest
 */
class TranscodedSizeEstimatorTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    protected function setUp()
    {
    }

    /**
     * testEstimatedBytes
     */
    public function testEstimatedBytes()
    {
        self::assertEquals(0, TranscodedSizeEstimator::estimatedBytes(0.0, 320));
        self::assertEquals(24000000, TranscodedSizeEstimator::estimatedBytes(1000.0, 192));
        self::assertEquals(40000000, TranscodedSizeEstimator::estimatedBytes(1000.0, 320));
        self::assertEquals(22195672, TranscodedSizeEstimator::estimatedBytes(554.891791, 320));
    }
}
