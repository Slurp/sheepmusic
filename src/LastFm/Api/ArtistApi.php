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

use LastFmApi\Api\ArtistApi as BaseApi;

/**
 * Class ArtistApi.
 */
class ArtistApi extends BaseApi
{
    /**
     * {@inheritdoc}
     */
    public function getInfo($methodVars)
    {
        $vars = [
            'method' => 'artist.getinfo',
            'api_key' => $this->auth->apiKey,
        ];
        $vars = array_merge($vars, $methodVars);

        if ($call = $this->apiGetCall($vars)) {
            $call->mbid = (string) $call->artist->mbid;

            return $call;
        }

        return false;
    }
}
