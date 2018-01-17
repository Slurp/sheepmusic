<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
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
        return $this->get('black_sheep_music_library.services.streamer_service')->getStreamerForSong(
            $song,
            $request->get('time', 0)
        );
    }
}
