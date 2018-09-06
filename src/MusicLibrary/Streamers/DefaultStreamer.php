<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Streamers;

use Symfony\Component\HttpFoundation\Response;

class DefaultStreamer extends AbstractStreamer implements AudioStreamInterface
{
    public function getStreamedResponse()
    {
        $response = new Response();

        $contentType = 'audio/' . pathinfo($this->song->getPath(), PATHINFO_EXTENSION);

        $response->headers->set('X-Sendfile', $this->song->getPath());
        $response->headers->set(
            'Content-Disposition',
            sprintf('inline; filename="%s"', basename($this->song->getPath()))
        );
        $response->headers->set('Content-Type', $contentType);
        $response->setStatusCode(200);

        return $response;
    }
}
