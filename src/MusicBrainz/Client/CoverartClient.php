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

use Psr\Http\Message\ResponseInterface;

/**
 * Class ReleaseClient.
 */
class CoverartClient extends JsonClient
{
    const BASE_URL = 'http://coverartarchive.org/';
    const END_POINT = 'release/';

    /**
     * @param $mbId
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return ResponseInterface
     */
    public function getCover($mbId): ResponseInterface
    {
        return $this->getClient()->send($this->makeRequest(static::END_POINT . $mbId));
    }
}
