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
    protected array $songInfo;

    protected function setUp(): void
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
        self::bootKernel();

        $songImporter = static::$container->get('black_sheep_music_scanner.services.song_importer');
        $finder = Finder::create()
            ->files()
            ->name('/\.(mp3|ogg|m4a|flac)$/i')
            ->in(__DIR__ . '/../../');
        foreach ($finder as $file) {
            $song = $songImporter->importSong($file);
            self::assertSame($song->getAlbum()->getName(), $this->songInfo['album']);
            self::assertSame($song->getArtist()->getName(), $this->songInfo['artist']);
            self::assertSame($song->getLength(), $this->songInfo['length']);
            self::assertSame($song->getTitle(), $this->songInfo['title']);
            self::assertSame($song->getTrack(), '0');
        }
    }
}
