<?php
namespace Tests\BlackSheep\MusicLibraryBundle\Streamers\Transcoder;

use BlackSheep\MusicLibraryBundle\Streamers\Transcoder\Inspector;
use PHPUnit_Framework_TestCase;

/**
 * Test the inspector
 */
class InspectorTest extends PHPUnit_Framework_TestCase
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
        self::assertEquals('554.891791', Inspector::getLength($this->flacPath));
        self::assertEquals('0.0', Inspector::getLength(''));
    }
}
