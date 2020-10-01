<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Controller;

use BlackSheep\MusicLibrary\Entity\SongEntity;
use BlackSheep\MusicLibrary\Services\StreamerService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A controller to stream a song to someone.
 */
class SongController extends AbstractController
{
    /**
     * @var StreamerService
     */
    protected StreamerService $streamerService;

    /**
     * SongController constructor.
     *
     * @param StreamerService $streamerService
     */
    public function __construct(StreamerService $streamerService)
    {
        $this->streamerService = $streamerService;
    }

    /**
     * @Route("/play/{song}", name="song_play")
     *
     * @param SongEntity $song
     * @param Request    $request
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function play(SongEntity $song, Request $request)
    {
        try {
            return $this->streamerService->getStreamerForSong(
                $song,
                $this->getUser(),
                $request->get('time', 0)
            );
        } catch (FileNotFoundException $exception) {
            return new Response('song is not available:' . $exception->getMessage(), 404);
        } catch (\Exception $exception) {
            return new Response('streaming failed:' . $exception->getMessage(), 500);
        }
    }
}
