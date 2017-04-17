<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Playlist;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PlaylistEntity extends Playlist
{
    use BaseEntity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="SongEntity", mappedBy="playlist")
     */
    protected $songs;

    /**
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function addSong(SongInterface $song)
    {
        if ($this->songs->contains($song) === false) {
            $this->songs->add($song);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeSong(SongInterface $song)
    {
        if ($this->songs->contains($song) === true) {
            $this->songs->removeElement($song);
        }

        return $this;
    }

    /**
     * @param $name
     *
     * @return static
     */
    public static function create($name)
    {
        $playlist = new static();
        $playlist->setName($name);

        return $playlist;
    }
}
