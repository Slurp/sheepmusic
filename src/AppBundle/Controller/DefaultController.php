<?php

namespace AppBundle\Controller;

use AppBundle\Utils\UtilsPagerFanta;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * A DefaultController, why change something that works.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->forward('AppBundle:Album:recentAlbums');
    }

    /**
     * @Route("/artists/{page}", defaults={"page" = 1}, name="library_artists")
     * @param $page
     *
     * @return Response
     */
    public function artistAction($page = 1)
    {
        $pager = UtilsPagerFanta::getAllPaged(
            $this->getDoctrine()->getRepository(ArtistsEntity::class),
            $page
        );

        return $this->render(
            'AppBundle:Artist:overview.html.twig',
            [
                'pager' => $pager,
                'artists' => $pager->getCurrentPageResults()
            ]
        );
    }

    /**
     * @Route("/artist/{artist}", name="library_artist")
     * @ParamConverter(
     *     "artist",
     *     class="BlackSheepMusicLibraryBundle:ArtistsEntity",
     *     options={"mapping": {"artist": "slug"}}
     * )
     *
     * @param ArtistsEntity $artist
     *
     * @return Response
     */
    public function artistDetailAction(ArtistsEntity $artist)
    {
        return $this->render('AppBundle:Artist:detail.html.twig', ['artist' => $artist]);
    }



    /**
     * List all the playlists!!!!
     * @Route("/playlists", name="library_playlists")
     *
     * @return Response
     */
    public function playlistsAction()
    {
        return $this->render(
            'AppBundle:Playlist:overview.html.twig',
            ['playlists' => $this->get('black_sheep_music_library.repository.playlist_repository')->findAll()]
        );
    }

    /**
     * @Route("/playlists/{playlist}", name="library_playlist")
     *
     * @param PlaylistEntity $playlist
     *
     * @return Response
     */
    public function playlistDetailAction(PlaylistEntity $playlist)
    {
        return $this->render(
            'AppBundle:Playlist:detail.html.twig',
            ['playlist' => $this->get('black_sheep_music_library.repository.playlist_repository')->find($playlist)]
        );
    }
}
