<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Playlist Api
 */
class PlaylistApiController extends BaseApiController
{
    /**
     * @inheritDoc
     */
    protected function getRepository()
    {
        return $this->get("black_sheep_music_library.repository.playlist_repository");
    }

    /**
     * @inheritDoc
     */
    protected function getApiDataModel()
    {
        return $this->get('black_sheep.music_library.api_model.api_playlist_data');
    }

    /**
     * @Route("/playlist_list", name="get_playlist_list")
     *
     * @return Response
     */
    public function getListAction()
    {
        return $this->getList();
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
            $songs = $this->get('black_sheep_music_library.repository.songs_repository')->findById($songs);
            $playlist = $this->getRepository()->savePlaylistWithSongs(
                $request->get('name'),
                $songs
            );
            if ($playlist) {
                return $this->getDetail($playlist);
            }
        }

        return $this->json(
            [
                'code' => 418,
                'message' => $request->getContent()->all(),
            ]
        );
    }
}
