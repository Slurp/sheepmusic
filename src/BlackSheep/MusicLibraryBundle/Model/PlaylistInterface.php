<?php
namespace BlackSheep\MusicLibraryBundle\Model;

/**
 *
 */
interface PlaylistInterface extends SongCollectionInterface
{
    /**
     * @param string|null $name
     *
     * @return PlaylistInterface
     */
    public static function create($name = null);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @return AlbumInterface[]
     */
    public function getAlbums();

    /**
     * @return string
     */
    public function getCover();

    /**
     * @param string $cover
     *
     * @return PlaylistInterface
     */
    public function setCover($cover);
}