<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 19/03/17
 * Time: 01:39
 * @copyright 2017 Bureau Blauwgeel
 * @version 1.0
 */
namespace Tests\BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Model\Album;
use PHPUnit_Framework_TestCase;

/**
 *
 */
class AlbumTest extends PHPUnit_Framework_TestCase
{
    protected $album;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $extraInfo['cover'] = "cover";
        $extraInfo['album_mbid'] = '';
        $this->album = Album::createArtistAlbum('test', 'test', $extraInfo);
    }

    /**
     *
     */
    public function testCreateAlbumEmptyInfo()
    {
        Album::createArtistAlbum('test', 'test', []);
    }

    /**
     *
     */
    public function testCreateAlbum()
    {
        $extraInfo['cover'] = "cover";
        $extraInfo['album_mbid'] = '';
        self::assertEquals($this->album, Album::createArtistAlbum('test', 'test', $extraInfo));
    }
}
