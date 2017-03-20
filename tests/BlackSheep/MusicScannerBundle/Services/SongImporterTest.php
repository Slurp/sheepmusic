<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 20/03/17
 * Time: 00:18
 * @copyright 2017 Bureau Blauwgeel
 * @version 1.0
 */
namespace Tests\BlackSheep\MusicScannerBundle\Services;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SongImporterTest extends KernelTestCase
{
    protected $songInfo;

    protected function setUp()
    {
        $this->songInfo = [
            'artist' => 'artist',
            'album' => 'the album',
            'title' => 'track title',
            'length' => 666.33,
            'lyrics' => '',
            'path' => 'path',
            'mTime' => '',
            'track' => 9,
            'artist_mbid' => '',
            'album_mbid' => '',
        ];
    }

    public function testSongImport()
    {
        //start the symfony kernel
        $kernel = static::createKernel();
        $kernel->boot();

        $songImporter = $kernel->getContainer()->get('black_sheep_music_scanner.services.song_importer');
        $song = $songImporter->importSong($this->songInfo);
        self::assertEquals($song->getAlbum()->getName(), $this->songInfo['album']);
        self::assertEquals($song->getArtist()->getName(), $this->songInfo['artist']);
        self::assertEquals($song->getLength(), 666.33);
        self::assertEquals($song->getTitle(), 'track title');
        self::assertEquals($song->getPath(), 'path');
        self::assertEquals($song->getTrack(), '9');
    }
}
