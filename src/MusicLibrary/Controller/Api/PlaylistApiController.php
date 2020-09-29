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

use BlackSheep\MusicLibrary\ApiModel\ApiPlaylistData;
use BlackSheep\MusicLibrary\Entity\PlaylistEntity;
use BlackSheep\MusicLibrary\Repository\PlaylistRepository;
use BlackSheep\MusicLibrary\Repository\SongsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Playlist Api.
 */
class PlaylistApiController extends BaseApiController
{
    /**
     * @var SongsRepository
     */
    protected $songsRepository;

    /**
     * PlaylistApiController constructor.
     *
     * @param PlaylistRepository $repository
     * @param ApiPlaylistData $apiData
     * @param SongsRepository $songsRepository
     */
    public function __construct(
        PlaylistRepository $repository,
        ApiPlaylistData $apiData,
        SongsRepository $songsRepository
    ) {
        $this->repository = $repository;
        $this->apiData = $apiData;
        $this->songsRepository = $songsRepository;
    }

    /**
     * @Route("/playlist_list", name="get_playlist_list")
     *
     * @return Response
     */
    public function getPlaylists()
    {
        if ($this->getUser() === null) {
            return $this->getList();
        }

        return $this->json($this->getRepository()->getListForUser($this->getUser()));
    }

    /**
     * @Route("/playlist/{playlist}", name="get_playlist")
     *
     * @param PlaylistEntity $playlist
     *
     * @return Response
     */
    public function getPlaylist(PlaylistEntity $playlist)
    {
        return $this->getDetail($playlist);
    }

    /**
     * @Route("/save/playlist", name="post_save_playlist")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postSavePlaylist(Request $request)
    {
        $songs = $request->get('songs');
        if ($songs !== null && is_array($songs)) {
            $songs = $this->songsRepository->findById($songs);
            $playlist = $this->getRepository()->savePlaylistWithSongs(
                $request->get('name'),
                $songs,
                $this->getUser()
            );
            if ($playlist) {
                return $this->getDetail($playlist);
            }
        }

        return $this->json(
            [
                'code' => 418,
                'message' => $request->getContent(),
            ]
        );
    }
}
