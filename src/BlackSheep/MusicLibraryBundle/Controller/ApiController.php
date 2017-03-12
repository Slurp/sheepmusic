<?php

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
use BlackSheep\MusicLibraryBundle\Events\SongEvent;
use BlackSheep\MusicLibraryBundle\Events\SongEventInterface;
use BlackSheep\MusicLibraryBundle\Model\Artist;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller Build upon the FOSRestController.
 *
 * @todo Refactor the repo's to services
 */
class ApiController extends Controller
{
    /**
     * @Route("/user", name="get_user")
     */
    public function getUserAction()
    {
        return $this->json(
            [
                'currentUser' => $this->getUser(),
            ]
        );
    }

    /**
     * @Route("/artists", name="get_artists")
     */
    public function getArtistsAction()
    {
        $adapter = new DoctrineORMAdapter(
            $this->getDoctrine()->getRepository(ArtistsEntity::class)->fetchPage(),
            false
        );
        $pager = new Pagerfanta($adapter);
        $artists = [];
        $apiData = $this->get('black_sheep.music_library.api_model.api_artist_data');
        /** @var Artist $artist */
        foreach ($pager->getCurrentPageResults() as $artist) {
            $artists[] = $apiData->getApiData($artist);
        }

        return $this->json($artists);
        //return $this->handleView($this->view(['artists' => ]));
    }

    /**
     * @Route("/albums", name="get_albums")
     *
     * @return Response
     */
    public function albumsAction()
    {
        return $this->json(
            [
                'albums' => $this->getDoctrine()->getRepository(AlbumEntity::class)->findAll(),
            ]
        );
    }

    /**
     * @Route("/artist/{artist}", name="get_artist")
     *
     * @param ArtistsEntity $artist
     *
     * @return Response
     */
    public function getArtistAction(ArtistsEntity $artist)
    {
        return $this->json($this->get('black_sheep.music_library.api_model.api_artist_data')->getApiData($artist));
    }

    /**
     * @Route("/album/{album}", name="get_album")
     *
     * @param AlbumEntity $album
     *
     * @return Response
     */
    public function getAlbumAction(AlbumEntity $album)
    {
        return $this->json($this->get('black_sheep.music_library.api_model.api_album_data')->getApiData($album));
    }

    /**
     * @Route("/announce/{song}", name="post_announce_song")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function postAnnounceSongAction(SongEntity $song)
    {
        $this->get('delayed_event_dispatcher')->dispatch(SongEventInterface::SONG_EVENT_PLAYING, new SongEvent($song));

        return $this->json(['played' => $song->getPlayCount()]);
    }

    /**
     * @Route("/played/{song}", name="post_played_song")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function postPlayedSongAction(SongEntity $song)
    {
        $event = new SongEvent($song);
        $this->get('event_dispatcher')->dispatch(SongEventInterface::SONG_EVENT_PLAYED, $event);

        return $this->json(['played' => $song->getPlayCount()]);
    }

    /**
     * @Route("/song/{song}", name="get_song_info")
     *
     * @param SongEntity $song
     *
     * @return Response
     */
    public function getSongInfoAction(SongEntity $song)
    {
        return $this->json($this->get('black_sheep.music_library.api_model.api_song_data')->getApiData($song));
    }
}
