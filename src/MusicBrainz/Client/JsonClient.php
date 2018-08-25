<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicBrainz\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

/**
 * Class JsonClient.
 */
class JsonClient
{
    /**
     * BASE_URL FOR THE API.
     */
    const BASE_URL = 'http://musicbrainz.org/ws/2/';

    /**
     * @return Client
     */
    protected function getClient()
    {
        return new Client();
    }

    /**
     * @param string $endpoint
     *
     * @return GuzzleRequest
     */
    protected function makeRequest($endpoint)
    {
        $request = new GuzzleRequest(
            'GET',
            static::BASE_URL . $endpoint
        );

        $request->withHeader('Accept', 'application/json');
        $request->withHeader('User-Agent', 'BlackSheep MusicApp');

        return $request;
    }
}
