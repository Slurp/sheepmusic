<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Song Api
 */
class PlaylistApiController extends Controller
{
    /**
     * @Route("/save/playlist", name="post_save_playlist")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postSavePlaylist(Request $request)
    {
        $name = $request->get('name');
        $playlist = $this->get("black_sheep_music_library.repository.playlist_repository")->getByName($name);
        if ($request->get('songs') !== null) {
            $songRepo = $this->get('black_sheep_music_library.repository.songs_repository');
            foreach ($request->get('songs') as $songId) {
                $song = $songRepo->findOneById($songId);
                $playlist->addSong($song);
            }
        }
        $this->get("black_sheep_music_library.repository.playlist_repository")->save($playlist);
        return $this->json(['saved' => $playlist->getName()]);
    }
}
