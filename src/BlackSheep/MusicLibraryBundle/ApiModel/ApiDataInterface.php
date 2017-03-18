<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use Symfony\Component\Routing\RouterInterface;

/**
 * Interface ApiData.
 */
interface ApiDataInterface
{
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router);

    /**
     * @param mixed
     *
     * @return array|null
     */
    public function getApiData($object);
}
