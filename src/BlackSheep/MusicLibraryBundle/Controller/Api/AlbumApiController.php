<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

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
    public function getAlbumsAction()
    {
        return $this->json(
            [
                'albums' => $this->getDoctrine()->getRepository(AlbumEntity::class)->findAll(),
            ]
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
