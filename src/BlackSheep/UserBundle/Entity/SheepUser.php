<?php

namespace BlackSheep\UserBundle\Entity;

use BlackSheep\LastFmBundle\Entity\Embeddable\LastFmUser;
use BlackSheep\LastFmBundle\Entity\LastFmUserEmbed;
use BlackSheep\MusicLibraryBundle\User\UserSettings;
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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var LastFmUser $lastFm
     * @ORM\Embedded(class = "BlackSheep\LastFmBundle\Entity\Embeddable\LastFmUserEmbeddable",columnPrefix = false)
     */
    protected $lastFm;

    /**
     * @var UserSettings
     * @ORM\Embedded(class = "BlackSheep\UserBundle\Entity\Settings",columnPrefix = false)
     */
    protected $settings;

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

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param mixed $settings
     *
     * @return SheepUser
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }
}
