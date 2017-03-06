<?php

namespace BlackSheep\UserBundle\Entity;

use BlackSheep\LastFmBundle\Entity\Embeddable\LastFmUser;
use BlackSheep\LastFmBundle\Entity\LastFmUserEmbed;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="sheep_users")
 */
class SheepUser extends BaseUser implements LastFmUserEmbed
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var LastFmUser $lastFm
     * @ORM\Embedded(class = "BlackSheep\LastFmBundle\Entity\Embeddable\LastFmUserEmbeddable",columnPrefix = false)
     */
    protected $lastFm;

    /**
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return LastFmUser
     */
    public function getLastFm()
    {
        return $this->lastFm;
    }

    /**
     * @param LastFmUser $lastFm
     *
     * @return SheepUser
     */
    public function setLastFm(LastFmUser $lastFm)
    {
        $this->lastFm = $lastFm;

        return $this;
    }
}
