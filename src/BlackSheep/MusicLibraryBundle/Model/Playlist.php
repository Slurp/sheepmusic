<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Traits\SongCollectionTrait;

/**
 *
 */
class Playlist implements PlaylistInterface
{
    use SongCollectionTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string $cover
     */
    protected $cover;

    /**
     * @param string|null $name
     *
     * @return PlaylistInterface
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
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAlbums()
    {
        $albums = [];
        foreach ($this->getSongs() as $song) {
            $albums[$song->getAlbum()->getSlug()] = $song->getAlbum();
        }
        return $albums;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     *
     * @return PlaylistInterface
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }
}
