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

use BlackSheep\MusicLibrary\Streamers\Transcoder\Inspector;
use PHPUnit\Framework\TestCase;

/**
 * Test the inspector.
 */
class InspectorTest extends TestCase
{
    /**
     * @var string
     */
    protected $flacPath;

    protected function setUp()
    {
        $this->flacPath = __DIR__ . '/../../../flac-file.flac';
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetLength()
    {
        $ffprobe = __DIR__ . '/../../../../node_modules/ffmpeg-binaries/bin/ffprobe';
        if (is_readable($ffprobe) === false || is_executable($ffprobe) === false) {
            $ffprobe = null;
        }
        self::assertSame('554.891791', Inspector::getLength($this->flacPath, $ffprobe));
        self::assertSame(0.0, Inspector::getLength('', $ffprobe));
    }
}
