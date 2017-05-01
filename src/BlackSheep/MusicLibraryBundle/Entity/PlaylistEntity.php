<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Playlist;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToMany(targetEntity="SongEntity", inversedBy="playlist", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="PlaylistSongs",
     *     joinColumns={@ORM\JoinColumn(name="playlist_id", referencedColumnName="id", nullable=true)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="songs_id", referencedColumnName="id", nullable=true)}
     * )
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
    public function addSong(SongInterface $song)
    {
        if ($this->songs->contains($song) === false) {
            $song->addPlaylist($this);
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
}
