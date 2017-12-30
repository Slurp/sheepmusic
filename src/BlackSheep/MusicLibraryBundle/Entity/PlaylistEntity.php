<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Playlist;
use BlackSheep\MusicLibraryBundle\Model\PlaylistsSongsInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\PlaylistRepository")
 */
class PlaylistEntity extends Playlist
{
    use BaseEntity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\OneToMany(
     *     targetEntity="BlackSheep\MusicLibraryBundle\Entity\PlaylistsSongsEntity",
     *     mappedBy="playlist",
     *     cascade={"all"},
     *     orphanRemoval=true
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     * @Assert\Valid()
     */
    protected $songs;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cover;

    /**
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public static function create($name = null)
    {
        $playlist = new static();
        if ($name === "" || $name === null) {
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
     * @inheritDoc
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
     * @inheritDoc
     */
    public function addSong(PlaylistsSongsInterface $song)
    {
        if ($this->songs->contains($song) === false) {
            $this->songs->add($song);
            $song->setPlaylist($this);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeSong(PlaylistsSongsInterface $song)
    {
        if ($this->songs->contains($song) === true) {
            $this->songs->removeElement($song);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getApiData()
    {
        $array = parent::getApiData();
        $array['id'] = $this->getId();
        $array['createdAt'] = $this->getCreatedAt();
        $array['updatedAt'] = $this->getUpdatedAt();

        return $array;
    }
}
