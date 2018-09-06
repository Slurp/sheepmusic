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
use FOS\UserBundle\Model\UserInterface;

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
     * @return UserInterface
     */
    public function setLastFm(LastFmUser $lastFm);
}
