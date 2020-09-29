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

use BlackSheep\MusicLibrary\ApiModel\ApiAlbumData;
use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\Helper\AlbumCoverHelper;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Handler\UploadHandler;

/**
 * Album api.
 */
class AlbumApiController extends BaseApiController
{
    /**
     * constructor.
     *
     * @param AlbumsRepository $repository
     * @param ApiAlbumData $apiData
     */
    public function __construct(
        AlbumsRepository $repository,
        ApiAlbumData $apiData
    ) {
        $this->repository = $repository;
        $this->apiData = $apiData;
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
