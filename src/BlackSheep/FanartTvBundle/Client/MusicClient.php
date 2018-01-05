<?php

namespace BlackSheep\FanartTvBundle\Client;

/**
 * Class MusicClient.
 */
class MusicClient extends JsonClient
{
    const END_POINT = 'music/';

    /**
     * @param $mbId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function loadArtist($mbId)
    {
        return $this->getClient()->send($this->makeRequest(static::END_POINT . $mbId));
    }
}
