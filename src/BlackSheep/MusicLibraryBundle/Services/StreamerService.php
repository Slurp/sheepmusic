<?php

namespace BlackSheep\MusicLibraryBundle\Services;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use BlackSheep\MusicLibraryBundle\Streamers\DefaultStreamer;
use BlackSheep\MusicLibraryBundle\Streamers\TranscodingStreamer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

/**
 * Streamer service.
 */
class StreamerService
{
    /**
     * @var string
     */
    private $ffmpegPath;

    /**
     * @var string
     */
    private $bitrate;

    /**
     * @var string
     */
    private $ffprobePath;

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
     * @param int $startTime
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function getStreamerForSong(SongInterface $song, $startTime = 0)
    {
        $songFile = new File($song->getPath());
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
