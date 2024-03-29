<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Services;

use BlackSheep\MusicLibrary\Model\SongInterface;
use BlackSheep\MusicLibrary\Streamers\DefaultStreamer;
use BlackSheep\MusicLibrary\Streamers\TranscodingStreamer;
use BlackSheep\User\Model\UserInterface;
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
    protected string $ffmpegPath;

    /**
     * @var string
     */
    protected string $bitrate;

    /**
     * @var string
     */
    protected string $ffprobePath;

    /**
     * @param string $ffmpegPath
     * @param string $ffprobePath
     * @param string $bitrate
     */
    public function __construct(string $ffmpegPath, string $ffprobePath, string $bitrate)
    {
        $this->ffmpegPath = $ffmpegPath;
        $this->bitrate = $bitrate;
        $this->ffprobePath = $ffprobePath;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreamerForSong(SongInterface $song, UserInterface $user = null, $startTime = 0): Response
    {
        $songFile = new File(mb_convert_encoding($song->getPath(), 'UTF-8'));
        $streamer = new DefaultStreamer($song);
        // If transcode parameter isn't passed, the default is to only transcode flac
        if ($songFile->getExtension() === 'flac' &&
            ($user !== null && $user->getPlayerSettings()->hasFlacSupport() === false)) {
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
