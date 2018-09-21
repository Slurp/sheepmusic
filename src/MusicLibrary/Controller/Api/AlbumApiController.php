<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Controller\Api;

use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Album api.
 */
class AlbumApiController extends BaseApiController
{
    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('black_sheep_music_library.repository.albums_repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiDataModel()
    {
        return $this->get('black_sheep.music_library.api_model.api_album_data');
    }

    /**
     * @Route("/album_list", name="get_album_list")
     *
     * @return Response
     */
    public function getAlbumList()
    {
        return $this->getList();
    }

    /**
     * @Route("/album_collection", name="get_album_collection")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getAlbumCollection(Request $request)
    {
        return $this->getCollection($request->get('objects'));
    }

    /**
     * @Route("/album/{album}", name="get_album")
     *
     * @param AlbumEntity $album
     *
     * @return Response
     */
    public function getAlbum(AlbumEntity $album)
    {
        return $this->getDetail($album);
    }
}
