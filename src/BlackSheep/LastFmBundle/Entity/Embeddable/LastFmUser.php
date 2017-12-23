<?php
namespace BlackSheep\LastFmBundle\Entity\Embeddable;

/**
 * Interface for the LastFm  User
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
     * @return boolean
     */
    public function isLastFmSubscriber();

    /**
     * @param boolean $lastFmSubscriber
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
}
