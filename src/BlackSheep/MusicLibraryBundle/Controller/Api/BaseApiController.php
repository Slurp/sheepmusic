<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\ApiModel\ApiDataInterface;
use BlackSheep\MusicLibraryBundle\Model\ApiInterface;
use BlackSheep\MusicLibraryBundle\Repository\AbstractRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseApiController.
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
