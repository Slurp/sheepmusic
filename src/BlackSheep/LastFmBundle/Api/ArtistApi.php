<?php

namespace BlackSheep\LastFmBundle\Api;

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
        } else {
            return false;
        }
    }
}
