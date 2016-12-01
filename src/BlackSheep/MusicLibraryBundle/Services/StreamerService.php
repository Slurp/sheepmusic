<?php
namespace BlackSheep\MusicLibraryBundle\Services;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use BlackSheep\MusicLibraryBundle\Streamers\DefaultStreamer;
use BlackSheep\MusicLibraryBundle\Streamers\TranscodingStreamer;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Streamer service
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
     * @param $ffmpegPath
     * @param $bitrate
     */
    public function __construct($ffmpegPath, $bitrate)
    {
        $this->ffmpegPath = $ffmpegPath;
        $this->bitrate    = $bitrate;
    }

    /**
     * Play a song.
     *
     * @param SongInterface $song
     * @param int   $startTime
     * @return \Symfony\Component\HttpFoundation\Response|void
     * @throws \Exception
     */
    public function getStreamerForSong(SongInterface $song, $startTime = 0)
    {
        $songFile  = new File($song->getPath());
        // If transcode parameter isn't passed, the default is to only transcode flac
        if ($songFile->getExtension() === "flac") {
            $streamer = new TranscodingStreamer($song, $this->bitrate, $this->ffmpegPath, $startTime);
        } else {
            $streamer = new DefaultStreamer($song);
        }

        return $streamer->getStreamedResponse();
    }
}
