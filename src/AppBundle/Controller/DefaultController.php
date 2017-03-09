<?php

namespace AppBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
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
        return $this->forward('AppBundle:Default:artist');
    }

    /**
     * @Route("/artists", name="library_artists")
     */
    public function artistAction()
    {
        $artists = $this->getDoctrine()->getRepository(ArtistsEntity::class)->findAll();
        return $this->render('AppBundle:Artist:overview.html.twig', ['artists' => $artists]);
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
     * @Route("/albums", name="library_albums")
     *
     * @return Response
     */
    public function albumsAction()
    {
        $albums = $this->getDoctrine()->getRepository(AlbumEntity::class)->findAll();

        return $this->render('AppBundle:Album:overview.html.twig', ['albums' => $albums]);
    }

    /**
     * @Route("/albums/recent", name="library_recent_albums")
     *
     * @return Response
     */
    public function recentAlbumsAction()
    {
        $albums = $this->getDoctrine()->getRepository(AlbumEntity::class)->getRecentAlbums();

        return $this->render('AppBundle:Album:overview.html.twig', ['albums' => $albums]);
    }

    /**
     * @Route("/album/{album}", name="library_album",requirements={"album"=".+"})
     * @ParamConverter(
     *     "album",
     *     class="BlackSheepMusicLibraryBundle:AlbumEntity",
     *     options={"mapping": {"album": "slug"}}
     * )
     *
     * @param AlbumEntity $album
     *
     * @return Response
     */
    public function albumDetailAction(AlbumEntity $album)
    {
        return $this->render(
            'AppBundle:Album:detail.html.twig',
            ['artist' => $album->getArtist(), 'album' => $album]
        );
    }
}
