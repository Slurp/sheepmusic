<?php
namespace BlackSheep\MusicLibraryBundle\Streamers;

use BlackSheep\MusicLibraryBundle\Entity\Songs;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Abstract Class to stream a song.
 */
abstract class AbstractStreamer implements AudioStreamInterface
{
    /**
     * @var Songs|string
     */
    protected $song;

    /**
     * @var string
     */
    protected $contentType;

    /**
     * BaseStreamer constructor.
     *
     * @param $song Songs
     */
    public function __construct(Songs $song)
    {
        $this->song = $song;

        if (file_exists($this->song->getPath() === false)) {
            throw new NotFoundHttpException();
        }

        $this->contentType = 'audio/' . pathinfo($this->song->getPath(), PATHINFO_EXTENSION);

        // Turn off error reporting to make sure our stream isn't interfered.
        @error_reporting(0);
    }

    /**
     * @return Response
     */
    abstract public function getStreamedResponse();
}