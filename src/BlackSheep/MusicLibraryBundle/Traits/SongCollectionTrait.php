<?php
namespace BlackSheep\MusicLibraryBundle\Traits;

use BlackSheep\MusicLibraryBundle\Model\SongInterface;

/**
 * Trait SongCollectionTrait
 *
 * @package BlackSheep\MusicLibraryBundle\Traits
 */
trait SongCollectionTrait
{
    /**
     * @var SongInterface[]
     */
    protected $songs;

    /**
     * @return SongInterface[]
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * {@inheritdoc}
     */
    public function setSongs($songs)
    {
        $this->songs = $songs;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addSong(SongInterface $song)
    {
        if (in_array($song, $this->songs) === false) {
            $this->songs[] = $song;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSong(SongInterface $song)
    {
        if (($key = array_search($song, $this->songs, true)) !== false) {
            unset($this->songs[$key]);
            $this->songs = array_values($this->songs);
        }

        return $this;
    }
}
