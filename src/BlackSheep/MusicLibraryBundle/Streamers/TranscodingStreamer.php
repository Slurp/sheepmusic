<?php
namespace BlackSheep\MusicLibraryBundle\Streamers;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Exception;

/**
 *
 */
class TranscodingStreamer extends AbstractStreamer implements AudioStreamInterface
{
    /**
     * Bitrate the stream should be transcoded at.
     *
     * @var int
     */
    private $bitrate;

    /**
     * Time point to start transcoding from.
     *
     * @var int
     */
    private $startTime;

    /**
     * @var
     */
    private $ffmpeg;

    /**
     * @param SongInterface $song
     * @param $bitrate
     * @param $ffmpeg
     * @param int $startTime
     */
    public function __construct(SongInterface $song, $bitrate, $ffmpeg, $startTime = 0)
    {
        parent::__construct($song);
        $this->bitrate = $bitrate;
        $this->startTime = $startTime;
        $this->ffmpeg = $ffmpeg;
    }

    /**
     *
     */
    public function getStreamedResponse()
    {
        if (is_executable($this->ffmpeg) === false) {
            throw new Exception('Transcoding requires valid ffmpeg settings.');
        }

        $bitRate = filter_var($this->bitrate, FILTER_SANITIZE_NUMBER_INT);

        header('Content-Type: audio/mpeg');
        header('Content-Disposition: attachment; filename="' . basename($this->song->getPath()) . '"');

        $args = [
            '-i ' . escapeshellarg($this->song->getPath()),
            '-map 0:0',
            '-v 0',
            "-ab {$bitRate}k",
            '-f mp3',
            '-',
        ];

        if ($this->startTime) {
            array_unshift($args, "-ss {$this->startTime}");
        }

        passthru("$this->ffmpeg " . implode($args, ' '));
    }
}
