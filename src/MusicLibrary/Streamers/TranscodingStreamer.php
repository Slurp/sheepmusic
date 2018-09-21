<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Streamers;

use BlackSheep\MusicLibrary\Model\SongInterface;
use BlackSheep\MusicLibrary\Streamers\Transcoder\FfmpegArgumentBuilder;
use BlackSheep\MusicLibrary\Streamers\Transcoder\Inspector;
use BlackSheep\MusicLibrary\Streamers\Transcoder\TranscodedSizeEstimator;
use Exception;

/**
 * Row, Row your code.
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
     * @var string
     */
    private $ffmpeg;

    /**
     * @var string
     */
    private $ffprobe;

    /**
     * @param SongInterface $song
     * @param int           $bitrate
     * @param string        $ffmpeg
     * @param string        $ffprobe
     * @param int           $startTime
     */
    public function __construct(SongInterface $song, $bitrate, $ffmpeg, $ffprobe, $startTime = 0)
    {
        parent::__construct($song);
        $this->bitrate = $bitrate;
        $this->startTime = $startTime;
        $this->ffmpeg = $ffmpeg;
        $this->ffprobe = $ffprobe;
    }

    /**
     * @throws Exception
     *
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function getStreamedResponse()
    {
        if (is_executable($this->ffmpeg) === false) {
            throw new Exception('Transcoding requires valid ffmpeg settings.');
        }
        if (is_executable($this->ffprobe) === false) {
            throw new Exception('Transcoding requires valid ffprobe settings.');
        }
        $bitRate = filter_var($this->bitrate, FILTER_SANITIZE_NUMBER_INT);
        $length = Inspector::getLength($this->song->getPath(), $this->ffprobe) - $this->startTime;
        HeaderBuilder::putHeader(
            $this->song->getPath(),
            TranscodedSizeEstimator::estimatedBytes($length, $this->bitrate)
        );
        passthru(
            "$this->ffmpeg " . FfmpegArgumentBuilder::getArguments($this->song->getPath(), $this->startTime, $bitRate)
        );
    }
}
