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
     * @return SheepUser
     */
    public function setLastFmToken($lastFmToken);

    /**
     * @return string
     */
    public function getLastFmUserName();

    /**
     * @param string $lastFmUserName
     *
     * @return SheepUser
     */
    public function setLastFmUserName($lastFmUserName);

    /**
     * @return string
     */
    public function getLastFmKey();

    /**
     * @param string $lastFmKey
     *
     * @return SheepUser
     */
    public function setLastFmKey($lastFmKey);

    /**
     * @return string
     */
    public function getLastFmSubscriber();

    /**
     * @param boolean $lastFmSubscriber
     *
     * @return SheepUser
     */
    public function setLastFmSubscriber($lastFmSubscriber);

    /**
     * @return bool
     */
    public function hasLastFmConnected();
}
