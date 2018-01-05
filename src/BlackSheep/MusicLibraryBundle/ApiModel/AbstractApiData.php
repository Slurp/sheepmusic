<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use Symfony\Component\Routing\RouterInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
     * @var UploaderHelper
     */
    protected $uploaderHelper;

    /**
     * @param RouterInterface $router
     * @param UploaderHelper  $uploaderHelper
     */
    public function __construct(RouterInterface $router, UploaderHelper $uploaderHelper)
    {
        $this->router = $router;
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * @param mixed
     *
     * @return array|null
     */
    abstract public function getApiData($object);
}
