<?php
namespace BlackSheep\MusicLibraryBundle\Streamers;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use BlackSheep\MusicLibraryBundle\Streamers\Transcoder\FfmpegArgumentBuilder;
use BlackSheep\MusicLibraryBundle\Streamers\Transcoder\Inspector;
use BlackSheep\MusicLibraryBundle\Streamers\Transcoder\TranscodedSizeEstimator;
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
        $length = Inspector::getLength($this->song->getPath()) - $this->startTime;
        HeaderBuilder::putHeader(
            $this->song->getPath(),
            TranscodedSizeEstimator::estimatedBytes($length, $this->bitrate)
        );
        passthru(
            "$this->ffmpeg " . FfmpegArgumentBuilder::getArguments($this->song->getPath(), $this->startTime, $bitRate)
        );
    }
}
