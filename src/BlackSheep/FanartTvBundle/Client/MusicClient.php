<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    /**
     * @param $mbId
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function loadAlbum($mbId)
    {
        return $this->getClient()->send($this->makeRequest(static::END_POINT . 'albums/' . $mbId));
    }
}
