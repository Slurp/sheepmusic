<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Controller\Api;

use BlackSheep\MusicLibrary\Entity\SongEntity;
use BlackSheep\MusicLibrary\Events\SongEvent;
use BlackSheep\MusicLibrary\Events\SongEventInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Song Api.
 */
class SongApiController extends Controller
{
    /**
     * @Route("/announce/{song}", name="post_announce_song")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function postAnnounceSongAction(SongEntity $song)
    {
        $this->get('delayed_event_dispatcher')->dispatch(SongEventInterface::SONG_EVENT_PLAYING, new SongEvent($song));

        return $this->json(['played' => $song->getPlayCount()]);
    }

    /**
     * @Route("/played/{song}", name="post_played_song")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function postPlayedSongAction(SongEntity $song)
    {
        $this->get('event_dispatcher')->dispatch(SongEventInterface::SONG_EVENT_PLAYED, new SongEvent($song));

        return $this->json(['played' => $song->getPlayCount()]);
    }

    /**
     * @Route("/song/{song}", name="get_song_info")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function getSongInfoAction(SongEntity $song)
    {
        return $this->json($this->get('black_sheep.music_library.api_model.api_song_data')->getApiData($song));
    }
}