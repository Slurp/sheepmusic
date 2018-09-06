<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\ApiModel;

use BlackSheep\MusicLibrary\Entity\PlaylistEntity;

/**
 * Generates a array for the API.
 */
class ApiPlaylistData extends ApiSongData implements ApiDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function getApiData($object)
    {
        if ($object instanceof PlaylistEntity) {
            $songs = [];
            foreach ($object->getSongs() as $song) {
                $songs[] = array_merge(
                    ['position' => $song->getPosition()],
                    parent::getApiData($song->getSong())
                );
            }

            return array_merge(
                [
                    'songs' => $songs,
                ],
                $object->getApiData()
            );
        }

        return null;
    }
}
