<?php

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\Albums;
use BlackSheep\MusicLibraryBundle\Entity\Artists;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="library")
     */
    public function indexAction()
    {
        $artists = $this->getDoctrine()->getRepository(Artists::class)->findAll();
        return $this->render('BlackSheepMusicLibraryBundle:Default:index.html.twig', ['artists' => $artists]);
    }

    /**
     * @Route("/recent/albums", name="library_recent_albums")
     *
     * @return Response
     */
    public function recentAlbumsAction()
    {
        $albums = $this->getDoctrine()->getRepository(Albums::class)->findAll();
        return $this->render('BlackSheepMusicLibraryBundle:Default:albums.html.twig', ['albums' => $albums]);
    }

    /**
     * @Route("/artist/{artist}", name="library_artist")
     *
     * @param Artists $artist
     * @return Response
     */
    public function artistDetailAction(Artists $artist)
    {
        return $this->render('BlackSheepMusicLibraryBundle:Default:artist.html.twig', ['artist' => $artist]);
    }

    /**
     * @Route("/artist/{artist}/album/{album},", name="library_album")
     *
     * @param Artists $artist
     * @param Albums $album
     * @return Response
     */
    public function albumDetailAction(Artists $artist, Albums $album)
    {
        return $this->render(
            'BlackSheepMusicLibraryBundle:Default:albums.html.twig',
            ['artist' => $artist , 'album' => $album]
        );
    }
}
