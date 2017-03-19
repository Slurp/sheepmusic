<?php
namespace Tests\BlackSheep\MusicScannerBundle\Helper;

use BlackSheep\MusicScannerBundle\Helper\TagHelper;
use PHPUnit_Framework_TestCase;

class TagHelperTest extends PHPUnit_Framework_TestCase
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
     * @expectedException TypeError
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
     * 'album_mbid' => '',
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
            'artist' => 'a',
            'album' => 'a',
            'title' => 't',
            'length' => 554.891791383219924682634882628917694091796875,
            'lyrics' => '',
            'path' => $file->getPathname(),
            'mTime' => $file->getMTime(),
            'track' => '',
            'artist_mbid' => '',
            'album_mbid' => '',
        ];
        self::assertEquals($props, $info);
    }
}
