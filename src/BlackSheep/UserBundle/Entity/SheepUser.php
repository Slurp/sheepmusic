<?php

namespace BlackSheep\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="sheep_users")
 */
class SheepUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastFmToken;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastFmUserName;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastFmKey;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastFmSubscriber;

    /**
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getLastFmToken()
    {
        return $this->lastFmToken;
    }

    /**
     * @param mixed $lastFmToken
     *
     * @return SheepUser
     */
    public function setLastFmToken($lastFmToken)
    {
        $this->lastFmToken = $lastFmToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastFmUserName()
    {
        return $this->lastFmUserName;
    }

    /**
     * @param string $lastFmUserName
     *
     * @return SheepUser
     */
    public function setLastFmUserName($lastFmUserName)
    {
        $this->lastFmUserName = $lastFmUserName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastFmKey()
    {
        return $this->lastFmKey;
    }

    /**
     * @param string $lastFmKey
     *
     * @return SheepUser
     */
    public function setLastFmKey($lastFmKey)
    {
        $this->lastFmKey = $lastFmKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastFmSubscriber()
    {
        return $this->lastFmSubscriber;
    }

    /**
     * @param boolean $lastFmSubscriber
     *
     * @return SheepUser
     */
    public function setLastFmSubscriber($lastFmSubscriber)
    {
        $this->lastFmSubscriber = $lastFmSubscriber;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasLastFm()
    {
        if ($this->getLastFmUserName() !== '') {
            return true;
        }

        return false;
    }
}
