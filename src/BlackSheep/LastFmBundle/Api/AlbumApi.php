<?php

namespace BlackSheep\LastFmBundle\Api;

use LastFmApi\Api\AlbumApi as BaseApi;

/**
 * Class AlbumApi
 *
 * @package BlackSheep\LastFmBundle\Api
 */
class AlbumApi extends BaseApi
{
    /**
     * @inheritDoc
     */
    public function getInfo($methodVars)
    {
        // Set the call variables
        $vars = [
            'method' => 'album.getinfo',
            'api_key' => $this->getAuth()->apiKey
        ];

        if ($call = $this->apiGetCall(array_merge($vars, $methodVars))) {
            $call->mbid = (string) $call->album->mbid;
            return $call;
        } else {
            return false;
        }
    }
}
