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

use BlackSheep\FanartTv\Client\MusicClient;
use BlackSheep\FanartTv\Model\FanartTvResponse;
use BlackSheep\MusicLibrary\ApiModel\ApiAlbumData;
use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Album api.
 */
class AlbumApiController extends BaseApiController
{
    /**
     * @var MusicClient
     */
    protected MusicClient $client;

    /**
     * constructor.
     *
     * @param AlbumsRepository $repository
     * @param ApiAlbumData $apiData
     * @param MusicClient $client
     */
    public function __construct(
        AlbumsRepository $repository,
        ApiAlbumData $apiData,
        MusicClient $client
    ) {
        $this->repository = $repository;
        $this->apiData = $apiData;
        $this->client = $client;
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

    /**
     * @Route("/album/{album}/artwork", name="get_album_artwork")
     *
     * @param AlbumEntity $album
     *
     * @return Response
     */
    public function getAlbumArtwork(AlbumEntity $album)
    {
        if ($album->getMusicBrainzId() !== null) {

                $fanart = new FanartTvResponse(
                    json_decode(
                        $this->client->loadAlbum($album->getMusicBrainzReleaseGroupId())->getBody()
                    )
                );

                return new JsonResponse($fanart->getArtworkCover());

        }

        return new JsonResponse(['']);
    }
}
