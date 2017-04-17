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
     * @Route("/save/playlist/{$name}", name="post_save_playlist")
     *
     * @param Request $request
     * @param $name
     *
     * @return Response
     */
    public function postSavePlaylist(Request $request, $name)
    {
        if ($name !== null) {
            $playlist = $this->get("black_sheep_music_library.repository.playlist_repository")->getByName($name);
            foreach ($request->get('songs') as $songId) {
                $playlist->addSong($this->get('black_sheep_music_library.repository.songs_repository')->find($songId));
            }

            return $this->json(['saved' => $playlist->getName()]);
        }

        return $this->json(['failed' => 'no name supplied']);
    }
}
