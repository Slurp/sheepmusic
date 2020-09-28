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
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class SheepUser implements LastFmUserEmbed, JWTUserInterface, UserInterface
{
    /**
     * @var int|string
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * Encrypted password. Must be persisted.
     *
     * @var string
     */
    protected $password;

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
     * @var array
     */
    protected $roles;

    /**
     * @param string $username
     * @param array $payload
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            'last_fm' => $this->getLastFm()->getApiData(),
            'settings' => $this->getSettings()->getApiData(),
            'player' => $this->getPlayerSettings()->getApiData(),
        ];
    }
}
