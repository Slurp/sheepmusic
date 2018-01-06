<?php

namespace Tests\BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

use BlackSheep\MusicLibraryBundle\Streamers\Transcoder\Inspector;
use PHPUnit\Framework\TestCase;

/**
 * Test the inspector
 */
class InspectorTest extends TestCase
{
    /**
     * @var string
     */
    protected $flacPath;

    /**
     *
     */
    protected function setUp()
    {
        $this->flacPath = __DIR__ . '/../../../../flac-file.flac';
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     *
     */
    public function testGetLength()
    {
        $ffprobe = __DIR__ . '/../../../../../var/bin/ffprobe';
        self::assertEquals('554.891791', Inspector::getLength($this->flacPath, $ffprobe));
        self::assertEquals('0.0', Inspector::getLength(''));
    }
}
