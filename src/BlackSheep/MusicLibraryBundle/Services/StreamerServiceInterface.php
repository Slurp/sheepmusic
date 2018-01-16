<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 15/01/2018
 * Time: 20:45.
 */

namespace BlackSheep\MusicLibraryBundle\Services;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Streamer service.
 */
interface StreamerServiceInterface
{
    /**
     * Play a song.
     *
     * @param SongInterface $song
     * @param int           $startTime
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function getStreamerForSong(SongInterface $song, $startTime = 0): Response;
}
