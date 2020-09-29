<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Services;

use BlackSheep\MusicLibrary\Model\SongInterface;
use BlackSheep\User\Entity\User;
use BlackSheep\User\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Streamer service.
 */
interface StreamerServiceInterface
{
    /**
     * Play a song.
     *
     * @param SongInterface  $song
     * @param UserInterface|null $user
     * @param int            $startTime
     *
     * @return Response
     */
    public function getStreamerForSong(SongInterface $song, UserInterface $user = null, $startTime = 0): Response;
}
