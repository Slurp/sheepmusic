<?php
namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface SongCollectionInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Model
 */
interface SongCollectionInterface
{
    /**
     * @return SongInterface[]
     */
    public function getSongs();

    /**
     * @param SongInterface[] $songs
     *
     * @return AlbumInterface
     */
    public function setSongs($songs);

    /**
     * @param SongInterface $song
     *
     * @return AlbumInterface
     */
    public function addSong(SongInterface $song);

    /**
     * @param SongInterface $song
     *
     * @return $this
     */
    public function removeSong(SongInterface $song);
}
