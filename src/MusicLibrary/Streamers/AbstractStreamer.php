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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Abstract Class to stream a song.
 */
abstract class AbstractStreamer implements AudioStreamInterface
{
    /**
     * @var SongInterface|string
     */
    protected $song;

    /**
     * @var string
     */
    protected $contentType;

    /**
     * BaseStreamer constructor.
     *
     * @param SongInterface $song
     */
    public function __construct(SongInterface $song)
    {
        $this->song = $song;

        if (file_exists($this->song->getPath() === false)) {
            throw new NotFoundHttpException();
        }

        $this->contentType = 'audio/' . pathinfo($this->song->getPath(), PATHINFO_EXTENSION);
    }

    /**
     * @return Response
     */
    abstract public function getStreamedResponse();
}
