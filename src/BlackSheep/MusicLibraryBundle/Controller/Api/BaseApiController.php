<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\ApiModel\ApiDataInterface;
use BlackSheep\MusicLibraryBundle\Model\ApiInterface;
use BlackSheep\MusicLibraryBundle\Repository\AbstractRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseApiController
 *
 * @package BlackSheep\MusicLibraryBundle\Controller
 */
abstract class BaseApiController extends Controller
{
    /**
     * @return AbstractRepositoryInterface
     */
    abstract protected function getRepository();

    /**
     * @return ApiDataInterface
     */
    abstract protected function getApiDataModel();

    /**
     * @return Response
     */
    protected function getList()
    {
        return $this->json($this->getRepository()->getList());
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
