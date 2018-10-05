<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use BlackSheep\MusicLibrary\Model\Playlist;
use BlackSheep\MusicLibrary\Model\PlaylistInterface;
use BlackSheep\MusicLibrary\Model\PlaylistsSongsInterface;
use BlackSheep\User\Entity\SheepUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibrary\Repository\PlaylistRepository")
 * @ApiResource
 */
class PlaylistEntity extends Playlist
{
    use BaseEntity;

    /**
     * @var SheepUser
     * @ORM\ManyToMany(targetEntity="BlackSheep\User\Entity\SheepUser")
     * @ORM\JoinTable(name="user_playlists",
     *      joinColumns={@ORM\JoinColumn(name="playlist_id", referencedColumnName="id", unique=true)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $user;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\OneToMany(
     *     targetEntity="BlackSheep\MusicLibrary\Entity\PlaylistsSongsEntity",
     *     mappedBy="playlist",
     *     cascade={"all"},
     *     orphanRemoval=true
     * )
     * @ORM\OrderBy({"position": "ASC"})
     * @Assert\Valid
     */
    protected $songs;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cover;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public static function create($name = null): PlaylistInterface
    {
        $playlist = new static();
        if ($name === '' || $name === null) {
            $date = new \DateTime();
            $name = $date->format(DATE_W3C);
        }
        $playlist->setName($name);

        return $playlist;
    }

    /**
     * @return PlaylistsSongsInterface[]|ArrayCollection
     */
    public function getSongs()
    {
        if ($this->songs === null) {
            $this->songs = new ArrayCollection();
        }

        return $this->songs;
    }

    /**
     * {@inheritdoc}
     */
    public function setSongs($songs)
    {
        $this->songs = new ArrayCollection();
        $position = 0;
        foreach ($songs as $song) {
            $song->setPosition($position++);
            $this->addSong($song);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(PlaylistsSongsInterface $song): PlaylistInterface
    {
        if ($this->songs->contains($song) === false) {
            $this->songs->add($song);
            $song->setPlaylist($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSong(PlaylistsSongsInterface $song): PlaylistInterface
    {
        if ($this->songs->contains($song) === true) {
            $this->songs->removeElement($song);
        }

        return $this;
    }

    public function getUser(): \BlackSheep\User\Model\SheepUser
    {
        return $this->user->first();
    }

    public function setUser(\BlackSheep\User\Model\SheepUser $user = null): void
    {
        $this->user = new ArrayCollection();
        $this->user->add($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getApiData(): array
    {
        $array = parent::getApiData();
        $array['id'] = $this->getId();
        $array['createdAt'] = $this->getCreatedAt();
        $array['updatedAt'] = $this->getUpdatedAt();

        return $array;
    }
}
