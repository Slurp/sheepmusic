<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\User\Entity;

use BlackSheep\LastFm\Entity\Embeddable\LastFmUser;
use BlackSheep\LastFm\Entity\LastFmUserEmbed;
use BlackSheep\MusicLibrary\User\UserSettings;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sheep_users")
 */
class SheepUser extends BaseUser implements LastFmUserEmbed, JWTUserInterface, UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var LastFmUser
     * @ORM\Embedded(class="BlackSheep\LastFm\Entity\Embeddable\LastFmUserEmbeddable", columnPrefix=false)
     */
    protected $lastFm;

    /**
     * @var UserSettings
     * @ORM\Embedded(class="BlackSheep\User\Entity\Settings", columnPrefix=false)
     */
    protected $settings;

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
     * @return array
     */
    public function getApiData()
    {
        return [
            'user_name' => $this->getUsername(),
            'email' => $this->getEmail(),
            'last_fm' => $this->getLastFm()->getApiData(),
            'settings' => $this->getSettings()->getApiData(),
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
