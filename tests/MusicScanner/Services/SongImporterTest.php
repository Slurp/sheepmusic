<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\Tests\MusicScannerBundle\Services;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Finder\Finder;

class SongImporterTest extends KernelTestCase
{
    protected $songInfo;

    protected function setUp()
    {
        $file = new \SplFileInfo(__DIR__ . '/../../flac-file.flac');
        $this->songInfo = [
            'artist' => 'Marianne Thorsen',
            'album' => 'MOZART Violin Concertos (CD-resolution)',
            'title' => 'MOZART Violin Concerto in D major KV 218, I. Allegro (CD-resolution)',
            'length' => 554.891791383219924682634882628917694091796875,
            'lyrics' => '',
            'mTime' => $file->getMTime(),
            'track' => '',
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
        $finder = Finder::create()
            ->files()
            ->name('/\.(mp3|ogg|m4a|flac)$/i')
            ->in(__DIR__ . '/../../../');
        foreach ($finder as $file) {
            $song = $songImporter->importSong($file);
            self::assertEquals($song->getAlbum()->getName(), $this->songInfo['album']);
            self::assertEquals($song->getArtist()->getName(), $this->songInfo['artist']);
            self::assertEquals($song->getLength(), $this->songInfo['length']);
            self::assertEquals($song->getTitle(), $this->songInfo['title']);
            self::assertEquals($song->getTrack(), 0);
        }
    }
}
