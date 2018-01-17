<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use Symfony\Component\Routing\RouterInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Interface ApiData.
 */
interface ApiDataInterface
{
    /**
     * @param RouterInterface $router
     * @param UploaderHelper  $uploaderHelper
     * @return void
     */
    public function __construct(RouterInterface $router, UploaderHelper $uploaderHelper);

    /**
     * @param mixed
     * @param \BlackSheep\MusicLibraryBundle\Model\ApiInterface $object
     *
     * @return array|null
     */
    public function getApiData($object);
}
