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
use BlackSheep\MusicLibraryBundle\Model\Artist;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class AlbumTest extends TestCase
{
    protected $album;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $extraInfo['cover'] = "cover";
        $extraInfo['album_mbid'] = '';

        $this->album = Album::createArtistAlbum('test', Artist::createNew('test'), $extraInfo);
    }

    /**
     *
     */
    public function testCreateAlbumEmptyInfo()
    {
        $album = Album::createArtistAlbum('test', Artist::createNew('test'), []);
        static::assertEquals('test', $album->getName());
        static::assertEquals('test', $album->getArtist()->getName());
    }

    /**
     *
     */
    public function testCreateAlbum()
    {
        $extraInfo['cover'] = "cover";
        $extraInfo['album_mbid'] = '';
        self::assertEquals($this->album, Album::createArtistAlbum('test', Artist::createNew('test'), $extraInfo));
    }
}
