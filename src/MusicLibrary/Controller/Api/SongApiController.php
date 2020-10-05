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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Song Api.
 */
class SongApiController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $dispatcher;

    /**
     * SongApiController constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {

        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/announce/{song}", name="post_announce_song")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function postAnnounceSong(SongEntity $song)
    {
        $this->dispatcher->dispatch(new SongEvent($song),SongEventInterface::SONG_EVENT_PLAYING);

        return $this->json(['played' => $song->getPlayCount()]);
    }

    /**
     * @Route("/played/{song}", name="post_played_song")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function postPlayedSong(SongEntity $song)
    {
        $this->dispatcher->dispatch( new SongEvent($song), SongEventInterface::SONG_EVENT_PLAYED);

        return $this->json(['played' => $song->getPlayCount()]);
    }

    /**
     * @Route("/song/{song}", name="get_song_info")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function getSongInfo(SongEntity $song)
    {
        return $this->json($this->get('black_sheep.music_library.api_model.api_song_data')->getApiData($song));
    }
}
