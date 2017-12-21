<?php
namespace BlackSheep\LastFmBundle\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class LastFmUserEmbeddable implements LastFmUser
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastFmToken;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastFmUserName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastFmKey;

    /**
     * @ORM\Column(type="boolean", nullable=true)
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
    public function isLastFmSubscriber()
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
        return ($this->getLastFmUserName() !== '' && $this->getLastFmUserName() !== null);
    }

    /**
     * @return array
     */
    public function getApiData()
    {
        return [
            'user_name' => $this->getLastFmUserName(),
            'isConnected' => $this->hasLastFmConnected()
        ];
    }
}
