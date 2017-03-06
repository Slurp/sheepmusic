<?php
namespace BlackSheep\LastFmBundle\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class LastFmUserEmbeddable implements LastFmUser
{
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
     * {@inheritdoc}
     */
    public function getLastFmToken()
    {
        return $this->lastFmToken;
    }

     /**
     * {@inheritdoc}
     */
    public function setLastFmToken($lastFmToken)
    {
        $this->lastFmToken = $lastFmToken;

        return $this;
    }

     /**
     * {@inheritdoc}
     */
    public function getLastFmUserName()
    {
        return $this->lastFmUserName;
    }

     /**
     * {@inheritdoc}
     */
    public function setLastFmUserName($lastFmUserName)
    {
        $this->lastFmUserName = $lastFmUserName;

        return $this;
    }

     /**
     * {@inheritdoc}
     */
    public function getLastFmKey()
    {
        return $this->lastFmKey;
    }

     /**
     * {@inheritdoc}
     */
    public function setLastFmKey($lastFmKey)
    {
        $this->lastFmKey = $lastFmKey;

        return $this;
    }

     /**
     * {@inheritdoc}
     */
    public function getLastFmSubscriber()
    {
        return $this->lastFmSubscriber;
    }

     /**
     * {@inheritdoc}
     */
    public function setLastFmSubscriber($lastFmSubscriber)
    {
        $this->lastFmSubscriber = $lastFmSubscriber;

        return $this;
    }

     /**
     * {@inheritdoc}
     */
    public function hasLastFmConnected()
    {
        if ($this->getLastFmUserName() !== '') {
            return true;
        }

        return false;
    }
}
