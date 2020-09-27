<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Entity;

use BlackSheep\LastFm\Entity\Embeddable\LastFmUser;
use BlackSheep\User\Model\SheepUser;

/**
 * Interface for the LastFm  User.
 */
interface LastFmUserEmbed
{
    /**
     * @return LastFmUser
     */
    public function getLastFm();

    /**
     * @param LastFmUser $lastFm
     *
     * @return SheepUser
     */
    public function setLastFm(LastFmUser $lastFm);
}
