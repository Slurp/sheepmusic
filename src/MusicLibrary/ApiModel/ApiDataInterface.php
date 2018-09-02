<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\ApiModel;

use BlackSheep\MusicLibrary\Model\ApiInterface;
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
     */
    public function __construct(RouterInterface $router, UploaderHelper $uploaderHelper);

    /**
     * @param ApiInterface $object
     *
     * @return array|null
     */
    public function getApiData($object);
}
