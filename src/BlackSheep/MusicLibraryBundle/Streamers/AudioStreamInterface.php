<?php
namespace BlackSheep\MusicLibraryBundle\Streamers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface AudioStreamInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Streamers
 */
interface AudioStreamInterface
{
    /**
     * @return Response
     */
    public function getStreamedResponse();
}
