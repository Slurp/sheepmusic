<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTv\Client;

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
    const BASE_URL = 'https://webservice.fanart.tv/v3/';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * JsonClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey = 'b624cd6523fbe1cee6de39a292e65917')
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return new Client();
    }

    /**
     * @param string $endpoint
     */
    protected function makeRequest($endpoint)
    {
        return new GuzzleRequest(
            'GET',
            static::BASE_URL . $endpoint . '?api_key=' . $this->apiKey
        );
    }
}
