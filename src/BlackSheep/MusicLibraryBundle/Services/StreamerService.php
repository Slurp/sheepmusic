<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Services;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use BlackSheep\MusicLibraryBundle\Streamers\DefaultStreamer;
use BlackSheep\MusicLibraryBundle\Streamers\TranscodingStreamer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

/**
 * Streamer service.
 */
class StreamerService implements StreamerServiceInterface
{
    /**
     * @var string
     */
    protected $ffmpegPath;

    /**
     * @var string
     */
    protected $bitrate;

    /**
     * @var string
     */
    protected $ffprobePath;

    /**
     * @param $ffmpegPath
     * @param $ffprobePath
     * @param $bitrate
     */
    public function __construct($ffmpegPath, $ffprobePath, $bitrate)
    {
        $this->ffmpegPath = $ffmpegPath;
        $this->bitrate = $bitrate;
        $this->ffprobePath = $ffprobePath;
    }

    /**
     * Play a song.
     *
     * @param SongInterface $song
     * @param int           $startTime
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function getStreamerForSong(SongInterface $song, $startTime = 0): Response
    {
        $songFile = new File(mb_convert_encoding($song->getPath(), "UTF-8"));
        $streamer = new DefaultStreamer($song);
        // If transcode parameter isn't passed, the default is to only transcode flac
        if ($songFile->getExtension() === 'flac') {
            $streamer = new TranscodingStreamer(
                $song,
                $this->bitrate,
                $this->ffmpegPath,
                $this->ffprobePath,
                $startTime
            );
        }

        return $streamer->getStreamedResponse();
    }
}
