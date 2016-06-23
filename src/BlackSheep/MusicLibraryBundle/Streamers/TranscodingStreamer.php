<?php
/**
 * @author    : @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 23/06/16
 * Time: 22:25
 * @copyright 2016 Bureau Blauwgeel
 * @version   1.0
 */
namespace BlackSheep\MusicLibraryBundle\Streamers;

use BlackSheep\MusicLibraryBundle\Entity\Songs;
use Exception;

/**
 *
 */
class TranscodingStreamer extends AbstractStreamer
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
     * @param Songs $song
     * @param       $bitrate
     * @param       $ffmpeg
     * @param int   $startTime
     */
    public function __construct(Songs $song, $bitrate, $ffmpeg, $startTime = 0)
    {
        parent::__construct($song);
        $this->bitrate   = $bitrate;
        $this->startTime = $startTime;
        $this->ffmpeg    = $ffmpeg;
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

        passthru("$ffmpeg " . implode($args, ' '));
    }
}
