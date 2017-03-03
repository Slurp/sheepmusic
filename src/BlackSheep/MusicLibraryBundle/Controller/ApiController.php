<?php

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
use BlackSheep\MusicLibraryBundle\Events\SongEvent;
use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller Build upon the FOSRestController.
 *
 * @todo Refactor the repo's to services
 */
class ApiController extends FOSRestController
{
    /**
     * @Route("/user", options={"expose"=true})
     */
    public function getUserAction()
    {
        $view = $this->view([
            'currentUser' => $this->getUser(),
        ]);

        return $this->handleView($view);
    }

    /**
     * @Route("/artists", options={"expose"=true})
     */
    public function getArtistsAction()
    {
        $adapter = new ArrayAdapter($this->getDoctrine()->getRepository(ArtistsEntity::class)->findAll());
        $pager = new Pagerfanta($adapter);

        return $this->handleView($this->view(['artists' => $pager->getCurrentPageResults()]));
    }

    /**
     * @Route("/albums", options={"expose"=true})
     *
     * @return Response
     */
    public function albumsAction()
    {
        $view = $this->view([
            'albums' => $this->getDoctrine()->getRepository(AlbumEntity::class)->findAll(),
        ]);

        return $this->handleView($view);
    }

    /**
     * @Route("/artist/{artist}", options={"expose"=true})
     *
     * @param ArtistsEntity $artist
     *
     * @return Response
     */
    public function getArtistAction(ArtistsEntity $artist)
    {
        $view = $this->view($this->get('black_sheep.music_library.api_model.api_artist_data')->getApiData($artist));

        return $this->handleView($view);
    }

    /**
     * @Route("/album/{album}", options={"expose"=true})
     *
     * @param AlbumEntity $album
     *
     * @return Response
     */
    public function getAlbumAction(AlbumEntity $album)
    {
        $view = $this->view($this->get('black_sheep.music_library.api_model.api_album_data')->getApiData($album));

        return $this->handleView($view);
    }

    /**
     * @Route("/played/{song}", options={"expose"=true})
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function postPlayedSongAction(SongEntity $song)
    {
        $event = new SongEvent($song);
        $this->get('event_dispatcher')->dispatch(SongEventInterface::SONG_EVENT_PLAYED, $event);

        return $this->handleView($this->view(['played' => $song->getPlayCount()]));
    }

    /**
     * @Route("/song/{song}", options={"expose"=true})
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function getSongInfoAction(SongEntity $song)
    {
        $view = $this->view($this->get('black_sheep.music_library.api_model.api_song_data')->getApiData($song));

        return $this->handleView($view);
    }
}
