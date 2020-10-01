<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\Tests\MusicLibrary\Model;

use BlackSheep\MusicLibrary\Model\Album;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Model\Artist;
use PHPUnit\Framework\TestCase;

class AlbumTest extends TestCase
{
    protected AlbumInterface $album;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $extraInfo['cover'] = 'cover';
        $extraInfo['album_mbid'] = '';

        $this->album = Album::createArtistAlbum('test', Artist::createNew('test'), $extraInfo);
    }

    public function testCreateAlbumEmptyInfo()
    {
        $album = Album::createArtistAlbum('test', Artist::createNew('test'), []);
        static::assertSame('test', $album->getName());
        static::assertSame('test', $album->getArtist()->getName());
    }

    public function testCreateAlbum()
    {
        $extraInfo['cover'] = 'cover';
        $extraInfo['album_mbid'] = '';
        self::assertSame($this->album->getApiData(), Album::createArtistAlbum('test', Artist::createNew('test'), $extraInfo)->getApiData());
    }
}
