<?php
namespace BlackSheep\LastFmBundle\Entity;

use BlackSheep\LastFmBundle\Entity\Embeddable\LastFmUser;
use FOS\UserBundle\Model\UserInterface;

/**
 * Interface for the LastFm  User
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