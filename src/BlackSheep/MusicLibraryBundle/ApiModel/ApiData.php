<?php
namespace BlackSheep\MusicLibraryBundle\ApiModel;

use Symfony\Component\Routing\RouterInterface;

/**
 * Interface ApiData
 *
 * @package BlackSheep\MusicLibrary\ApiModel
 */
interface ApiData
{
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router);

    /**
     * @param mixed
     * @return array
     */
    public function getApiData($object);
}