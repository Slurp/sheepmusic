<?php

namespace BlackSheep\FanartTvBundle\Client;

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
     * JsonClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey = '29133f7285818dcf83d712fabd9b5d2e')
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
