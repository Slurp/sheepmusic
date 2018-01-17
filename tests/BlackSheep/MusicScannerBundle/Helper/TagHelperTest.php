<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\BlackSheep\MusicScannerBundle\Helper;

use BlackSheep\MusicScannerBundle\Helper\TagHelper;
use PHPUnit\Framework\TestCase;

class TagHelperTest extends TestCase
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
     * @expectedException \TypeError
     * @expectedExceptionMessage Argument 1 passed to BlackSheep\MusicScannerBundle\Helper\TagHelper::getInfo() must be
     *     an instance of SplFileInfo, string given
     */
    public function testGetInfoNoFile()
    {
        $tagHelper = new TagHelper();
        $tagHelper->getInfo('');
    }

    public function testGetInfoTestError()
    {
        $file = new \SplFileInfo(__DIR__ . '/../../../../flac-file.flac');
        $tagHelper = new TagHelper();
        $info = $tagHelper->getInfo($file);
        self::assertEquals(null, $info);
    }

    /**
     * 'artist' => '',
     * 'album' => '',
     * 'title' => '',
     * 'length' => $info['playtime_seconds'],
     * 'lyrics' => '',
     * 'cover' => $this->getCover($info),
     * 'path' => $file->getPathname(),
     * 'mTime' => $file->getMTime(),
     * 'track' => '',
     * 'artist_mbid' => '',
     * 'album_mbid' => '',.
     */
    public function testGetInfoWithFile()
    {
        $file = new \SplFileInfo($this->flacPath);
        $tagHelper = new TagHelper();
        $info = $tagHelper->getInfo($file);
        self::assertArrayHasKey('artist', $info);
        self::assertArrayHasKey('album', $info);
        self::assertArrayHasKey('title', $info);
        self::assertArrayHasKey('length', $info);
        self::assertArrayHasKey('lyrics', $info);
        self::assertArrayHasKey('cover', $info);
        self::assertArrayHasKey('path', $info);
        self::assertArrayHasKey('mTime', $info);
        self::assertArrayHasKey('track', $info);
        self::assertArrayHasKey('artist_mbid', $info);
        self::assertArrayHasKey('album_mbid', $info);
    }

    public function testValuesForInfo()
    {
        $file = new \SplFileInfo($this->flacPath);
        $tagHelper = new TagHelper();
        $info = $tagHelper->getInfo($file);
        // cover is blob data test a other way
        unset($info['cover']);
        $props = [
            'artist' => 'Marianne Thorsen',
            'album' => 'MOZART Violin Concertos (CD-resolution)',
            'title' => 'MOZART Violin Concerto in D major KV 218, I. Allegro (CD-resolution)',
            'length' => 554.891791383219924682634882628917694091796875,
            'lyrics' => '',
            'path' => $file->getPathname(),
            'mTime' => $file->getMTime(),
            'track' => '',
            'artist_mbid' => '',
            'album_mbid' => '',
            'year' => '',
            'genre' => 'Art Music > Classical > Classical',
            'audio' => [
                'dataformat' => 'flac',
                'channels' => 2,
                'sample_rate' => 44100,
                'bitrate' => 722833.471729978802613914012908935546875,
                'channelmode' => 'stereo',
                'bitrate_mode' => 'vbr',
                'lossless' => true,
                'compression_ratio' => 0.5122119272463001582451624926761724054813385009765625,
            ],
        ];
        self::assertEquals($props, $info);
    }
}
