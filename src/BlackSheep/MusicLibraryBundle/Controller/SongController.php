<?php

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
use BlackSheep\MusicLibraryBundle\Events\SongEvent;
use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A controller to stream a song to someone.
 */
class SongController extends Controller
{
    /**
     * @Route("/play/{song}", name="song_play")
     *
     * @param SongEntity $song
     * @param Request    $request
     *
     * @return Response
     */
    public function playAction(SongEntity $song, Request $request)
    {
        $this->get('event_dispatcher')->dispatch(SongEventInterface::SONG_EVENT_PLAYING, new SongEvent($song));
        return $this->get('black_sheep_music_library.services.streamer_service')->getStreamerForSong(
            $song,
            $request->get('time', 0)
        );
    }
}
