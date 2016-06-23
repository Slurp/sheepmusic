<?php

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\Songs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class SongController extends Controller
{
    /**
     * @Route("/play/{song}", name="song_play")
     * @param Songs   $song
     * @param Request $request
     * @return Response
     */
    public function playAction(Songs $song, Request $request)
    {
        $streamer = $this->get('black_sheep_music_library.services.streamer_service');

        return $streamer->getStreamerForSong($song, $request->get('time', 0));
    }
}
