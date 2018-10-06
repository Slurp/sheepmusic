<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\User\Model;

use BlackSheep\LastFm\Entity\Embeddable\LastFmUser;
use BlackSheep\LastFm\Entity\LastFmUserEmbed;
use BlackSheep\MusicLibrary\User\UserSettings;
use BlackSheep\User\Entity\PlayerSettings;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class SheepUser extends BaseUser implements LastFmUserEmbed, JWTUserInterface, UserInterface
{
    protected $id;

    /**
     * @var LastFmUser
     */
    protected $lastFm;

    /**
     * @var UserSettings
     */
    protected $settings;

    /**
     * @var PlayerSettings
     */
    protected $playerSettings;

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
     * @return UserSettings
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

    /**
     * @return PlayerSettings
     */
    public function getPlayerSettings(): PlayerSettings
    {
        return $this->playerSettings;
    }

    /**
     * @param PlayerSettings $playerSettings
     */
    public function setPlayerSettings(PlayerSettings $playerSettings): void
    {
        $this->playerSettings = $playerSettings;
    }

    /**
     * @return array
     */
    public function getApiData()
    {
        return [
            'user_name' => $this->getUsername(),
            'email' => $this->getEmail(),
            'last_fm' => $this->getLastFm()->getApiData(),
            'settings' => $this->getSettings()->getApiData(),
            'player' => $this->getPlayerSettings()->getApiData(),
        ];
    }

    /**
     * @param string $username
     * @param array  $payload
     *
     * @return SheepUser
     */
    public static function createFromPayload($username, array $payload)
    {
        $user = new static();
        $user->setUsername($username);
        if (isset($payload['roles'])) {
            $user->setRoles($payload['roles']);
        }
        if (isset($payload['email'])) {
            $user->setEmail($payload['email']);
        }

        return $user;
    }
}
