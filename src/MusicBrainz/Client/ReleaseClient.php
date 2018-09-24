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
class ReleaseClient extends JsonClient
{
    const END_POINT = 'release/';

    /**
     * @param $mbId
     *
     * @return ResponseInterface
     */
    public function loadRelease($mbId): ResponseInterface
    {
        sleep(1);
        return $this->getClient()->send($this->makeRequest(static::END_POINT . $mbId . '?inc=release-groups&fmt=json'));
    }
}
