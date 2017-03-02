<?php

namespace BlackSheep\MusicLibraryBundle\Streamers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface AudioStreamInterface.
 */
interface AudioStreamInterface
{
    /**
     * @return Response
     */
    public function getStreamedResponse();
}
