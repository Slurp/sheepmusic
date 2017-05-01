<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use Symfony\Component\Routing\RouterInterface;

/**
 * A Abstract Class to define the router.
 */
abstract class AbstractApiData
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param mixed
     *
     * @return array|null
     */
    abstract public function getApiData($object);
}
