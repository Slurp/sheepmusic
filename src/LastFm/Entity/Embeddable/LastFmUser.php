<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Entity\Embeddable;

/**
 * Interface for the LastFm  User.
 */
interface LastFmUser
{
    /**
     * @return string
     */
    public function getLastFmToken();

    /**
     * @param string $lastFmToken
     *
     * @return LastFmUserEmbeddable
     */
    public function setLastFmToken($lastFmToken);

    /**
     * @return string
     */
    public function getLastFmUserName();

    /**
     * @param string $lastFmUserName
     *
     * @return LastFmUserEmbeddable
     */
    public function setLastFmUserName($lastFmUserName);

    /**
     * @return string
     */
    public function getLastFmKey();

    /**
     * @param string $lastFmKey
     *
     * @return LastFmUserEmbeddable
     */
    public function setLastFmKey($lastFmKey);

    /**
     * @return bool
     */
    public function isLastFmSubscriber();

    /**
     * @param bool $lastFmSubscriber
     *
     * @return LastFmUserEmbeddable
     */
    public function setLastFmSubscriber($lastFmSubscriber);

    /**
     * @return bool
     */
    public function hasLastFmConnected();

    /**
     * @param $token
     *
     * @return bool
     */
    public function disconnect($token);

    /**
     * @return array
     */
    public function getApiData();
}
