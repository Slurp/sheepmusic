<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Artist Model Class.
 */
class Artist implements ArtistInterface
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $musicBrainzId;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var string
     */
    protected $biography;

    /**
     * @var string
     */
    protected $playCount;

    /**
     * @var AlbumInterface[]
     */
    protected $albums;

    /**
     * @var SongInterface[]
     */
    protected $songs;

    /**
     * @param      $name
     * @param null $musicBrainzId
     *
     * @return ArtistInterface
     */
    public static function createNew($name, $musicBrainzId = null)
    {
        $artist = new self();
        $artist->setName($name);
        $artist->setMusicBrainzId($musicBrainzId);
        $artist->setPlayCount(0);

        return $artist;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return ArtistInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getMusicBrainzId()
    {
        return $this->musicBrainzId;
    }

    /**
     * @param mixed $musicBrainzId
     *
     * @return ArtistInterface
     */
    public function setMusicBrainzId($musicBrainzId)
    {
        if (is_array($musicBrainzId)) {
            $musicBrainzId = $musicBrainzId[0];
        }
        $this->musicBrainzId = $musicBrainzId;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return ArtistInterface
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     *
     * @return ArtistInterface
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * @return AlbumInterface[]
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param mixed $albums
     *
     * @return ArtistInterface
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;

        return $this;
    }

    /**
     * @return SongInterface[]
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * @param mixed $songs
     *
     * @return ArtistInterface
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
     * @return string
     */
    public function getPlayCount()
    {
        return $this->playCount;
    }

    /**
     * @param int $playCount
     *
     * @return ArtistInterface
     */
    public function setPlayCount($playCount)
    {
        $this->playCount = $playCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlbumArt()
    {
        /** @var Album $album */
        foreach ($this->getAlbums() as $album) {
            if ($album->getCover() !== null) {
                return $album->getCover();
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getApiData()
    {
        return [
            'name' => $this->getName(),
            'image' => $this->getImage(),
            'albumArt' => $this->getAlbumArt(),
        ];
    }
}
