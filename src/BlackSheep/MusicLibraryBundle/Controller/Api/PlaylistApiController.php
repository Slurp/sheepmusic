<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;
use BlackSheep\MusicLibraryBundle\Helper\PlaylistCoverHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Playlist Api
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
            $songs = $request->get('songs');
            if (count($songs) === 1) {
                $songs = explode(',', $songs[0]);
            }
            foreach ($songs as $songId) {
                $song = $songRepo->findOneById($songId);
                $playlist->addSong($song);
            }
            $cover = new PlaylistCoverHelper();
            $playlist->setCover($cover->createCoverForPlaylist($playlist, false));
            $this->get("black_sheep_music_library.repository.playlist_repository")->save($playlist);

            return $this->json(
                $this->get('black_sheep.music_library.api_model.api_playlist_data')->getApiData($playlist)
            );
        }

        return $this->json(
            [
                'code' => 418,
                'message' => $request->getContent()->all(),
            ]
        );
    }

    /**
     * @Route("/playlist/{playlist}", name="get_playlist")
     *
     * @param PlaylistEntity $playlist
     *
     * @return Response
     */
    public function getPlaylistAction(PlaylistEntity $playlist)
    {
        return $this->json($this->get('black_sheep.music_library.api_model.api_playlist_data')->getApiData($playlist));
    }

    /**
     * @Route("/playlist_list", name="get_playlist_list")
     *
     * @return Response
     */
    public function getListAction()
    {
        return $this->json(
            $this->getDoctrine()->getRepository(PlaylistEntity::class)->getLists()
        );
    }
}
