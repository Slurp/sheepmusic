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

use BlackSheep\MusicLibrary\ApiModel\ApiDataInterface;
use BlackSheep\MusicLibrary\Helper\AlbumCoverHelper;
use BlackSheep\MusicLibrary\Model\ApiInterface;
use BlackSheep\MusicLibrary\Repository\AbstractRepositoryInterface;
use BlackSheep\MusicLibrary\Repository\AlbumsRepository;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use BlackSheep\MusicScanner\Helper\TagHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Handler\UploadHandler;

/**
 * Class BaseApiController.
 */
abstract class BaseApiController extends AbstractController
{
    /**
     * @var AbstractRepositoryInterface
     */
    protected $repository;

    /**
     * @var ApiDataInterface;
     */
    protected $apiData;

    /**
     * @return AbstractRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return ApiDataInterface
     */
    protected function getApiDataModel()
    {
        return $this->apiData;
    }

    /**
     * @return Response
     */
    protected function getList()
    {
        return $this->json($this->getRepository()->getList());
    }

    protected function getCollection($ids)
    {
        $collection = [];

        foreach ($this->getRepository()->findById($ids) as $object) {
            $collection[] = $this->getApiDataModel()->getApiData($object);
        }

        return $this->json($collection);
    }

    /**
     * @param ApiInterface $object
     *
     * @return Response
     */
    protected function getDetail(ApiInterface $object)
    {
        return $this->json($this->getApiDataModel()->getApiData($object));
    }
}
