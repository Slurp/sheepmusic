<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use Symfony\Component\Routing\RouterInterface;

/**
 * Interface ApiData.
 */
interface ApiData
{
    /**
     * @param RouterInterface $router
     * @return void
     */
    public function __construct(RouterInterface $router);

    /**
     * @param mixed
     *
     * @return array
     */
    public function getApiData($object);
}
