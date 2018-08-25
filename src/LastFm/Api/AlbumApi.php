<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Api;

use LastFmApi\Api\AlbumApi as BaseApi;

/**
 * Class AlbumApi.
 */
class AlbumApi extends BaseApi
{
    /**
     * {@inheritdoc}
     */
    public function getInfo($methodVars)
    {
        // Set the call variables
        $vars = [
            'method' => 'album.getinfo',
            'api_key' => $this->getAuth()->apiKey,
        ];

        if ($call = $this->apiGetCall(array_merge($vars, $methodVars))) {
            $call->mbid = (string) $call->album->mbid;

            return $call;
        }

        return false;
    }
}
