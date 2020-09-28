<?php

namespace BlackSheep\User\Entity;

use BlackSheep\LastFm\Entity\Embeddable\LastFmUser;
use BlackSheep\MusicLibrary\User\UserSettings;
use BlackSheep\User\Model\SheepUser;
use BlackSheep\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="sheep_users")
 */
class User extends SheepUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;


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
     * @var PlayerSettings
     * @ORM\Embedded(class="BlackSheep\User\Entity\PlayerSettings", columnPrefix=false)
     */
    protected $playerSettings;


    public function getId(): ?int
    {
        return $this->id;
    }
}
