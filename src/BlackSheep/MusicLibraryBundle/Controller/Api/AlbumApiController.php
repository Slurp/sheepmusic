<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use AppBundle\Utils\UtilsPagerFanta;
use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Album api
 */
class AlbumApiController extends Controller
{
    /**
     * @Route("/albums", name="get_albums")
     *
     * @return Response
     */
    public function getAlbumsAction($page = 1)
    {
        $albums = [];
        $pager = UtilsPagerFanta::getByQuery(
            $this->getDoctrine()->getRepository(AlbumEntity::class)->getRecentAlbums(),
            $page
        );
        foreach ($pager->getCurrentPageResults() as $album) {
            $albums[] = $this->get('black_sheep.music_library.api_model.api_album_data')->getApiData($album);
        }

        return $this->json(
            $albums
        );
    }

    /**
     * @Route("/album_list", name="get_album_list")
     *
     * @return Response
     */
    public function getAlbumListAction()
    {
        return $this->json(
            $this->getDoctrine()->getRepository(AlbumEntity::class)->getAlbumsList()
        );
    }

    /**
     * @Route("/album_recent_list", name="get_album_recent_list")
     *
     * @return Response
     */
    public function getAlbumRecentListAction()
    {
        return $this->json(
            $this->getDoctrine()->getRepository(AlbumEntity::class)->getRecentAlbumsList()
        );
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
}
