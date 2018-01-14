<?php

namespace BlackSheep\LastFmBundle\Api;

use LastFmApi\Api\ArtistApi as BaseApi;

/**
 * Class ArtistApi
 *
 * @package BlackSheep\LastFmBundle\Api
 */
class ArtistApi extends BaseApi
{
    /**
     * @inheritDoc
     */
    public function getInfo($methodVars)
    {
        $vars = array(
            'method' => 'artist.getinfo',
            'api_key' => $this->auth->apiKey
        );
        $vars = array_merge($vars, $methodVars);

        if ($call = $this->apiGetCall($vars)) {
            $call->mbid = (string) $call->artist->mbid;
            return $call;
        } else {
            return false;
        }
    }
}
