<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Info;

use BlackSheep\LastFm\Api\AlbumApi;

/**
 * Get the Correct API.
 */
class LastFmAlbumInfo extends AbstractLastFmInfo implements LastFmInfo
{
    /**
     * @return AlbumApi
     */
    protected function getApi()
    {
        return new AlbumApi($this->getAuth());
    }
}
