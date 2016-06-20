<?php

namespace AppBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\Albums;
use BlackSheep\MusicLibraryBundle\Entity\Artists;
use BlackSheep\MusicLibraryBundle\Entity\Songs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $artists = $this->getDoctrine()->getRepository(Artists::class)->findAll();

        return $this->render('AppBundle:Default:index.html.twig', ['artists' => $artists]);
    }

    /**
     * @Route("/artists", name="library")
     */
    public function artistAction()
    {
        $artists = $this->getDoctrine()->getRepository(Artists::class)->findAll();

        return $this->render('AppBundle:Default:index.html.twig', ['artists' => $artists]);
    }

    /**
     * @Route("/artist/{artist}", name="library_artist")
     * @ParamConverter("artist", class="BlackSheepMusicLibraryBundle:Artists", options={"mapping": {"artist": "slug"}})
     * @param Artists $artist
     * @return Response
     */
    public function artistDetailAction(Artists $artist)
    {
        return $this->render('AppBundle:Default:artist.html.twig', ['artist' => $artist]);
    }

    /**
     * @Route("/albums", name="library_albums")
     * @return Response
     */
    public function albumsAction()
    {
        $albums = $this->getDoctrine()->getRepository(Albums::class)->findAll();

        return $this->render('AppBundle:Default:albums.html.twig', ['albums' => $albums]);
    }

    /**
     * @Route("/albums/recent", name="library_recent_albums")
     * @return Response
     */
    public function recentAlbumsAction()
    {
        $albums = $this->getDoctrine()->getRepository(Albums::class)->getRecentAlbums();

        return $this->render('AppBundle:Default:albums.html.twig', ['albums' => $albums]);
    }

    /**
     * @Route("/album/{album}", name="library_album",requirements={"album"=".+"})
     * @ParamConverter("album", class="BlackSheepMusicLibraryBundle:Albums", options={"mapping": {"album": "slug"}})
     * @param Artists $artist
     * @param Albums  $album
     * @return Response
     */
    public function albumDetailAction(Albums $album)
    {
        return $this->render(
            'AppBundle:Default:albums.html.twig',
            ['artist' => $album->getArtist(), 'album' => $album]
        );
    }

    /**
     * @Route("/song/{song}", name="library_song")
     * @param Songs $song
     * @return Response
     */
    public function songAction(Songs $song)
    {
        $response = new Response();

        if ($this->container->get('security.authorization_checker')->isGranted("ROLE_USER")) {
            $contentType = 'audio/' . pathinfo($song->getPath(), PATHINFO_EXTENSION);


            $response->headers->set('X-Sendfile', $song->getPath());
            $response->headers->set(
                'Content-Disposition',
                sprintf('inline; filename="%s"', basename($song->getPath()))
            );
            $response->headers->set('Content-Type', $contentType);
            $response->setStatusCode(200);

            return $response;
        } else {
            $response->setContent($song->getName());
            $response->setStatusCode(500);
        }
        return $response;
    }
}
