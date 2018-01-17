<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Traits\ArtworkCollectionTrait;
use BlackSheep\MusicLibraryBundle\Traits\GenreCollectionTrait;
use BlackSheep\MusicLibraryBundle\Traits\PlayCountTrait;
use BlackSheep\MusicLibraryBundle\Traits\SongCollectionTrait;

/**
 * Artist Model Class.
 */
class Artist implements ArtistInterface
{
    use GenreCollectionTrait;
    use SongCollectionTrait;
    use ArtworkCollectionTrait;
    use PlayCountTrait;

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
     * @var int
     */
    protected $playCount;

    /**
     * @var AlbumInterface[]
     */
    protected $albums;

    /**
     * @var ArtistInterface[]
     */
    protected $similarArtists;

    /**
     * {@inheritdoc}
     */
    public static function createNew($name, $musicBrainzId = null)
    {
        $artist = new static();
        $artist->setName($name);
        if ($musicBrainzId !== '') {
            $artist->setMusicBrainzId($musicBrainzId);
        }
        $artist->setPlayCount(0);

        return $artist;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
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
     * {@inheritdoc}
     */
    public function getMusicBrainzId()
    {
        return $this->musicBrainzId;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * {@inheritdoc}
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * {@inheritdoc}
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getSimilarArtists()
    {
        return $this->similarArtists;
    }

    /**
     * {@inheritdoc}
     */
    public function setSimilarArtists($similarArtists)
    {
        $this->similarArtists = $similarArtists;
    }

    /**
     * {@inheritdoc}
     */
    public function addSimilarArtist(ArtistInterface $similarArtist)
    {
        if (in_array($similarArtist, $this->similarArtists, true) === false) {
            $this->similarArtists[] = $similarArtist;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSimilarArtist(ArtistInterface $similarArtist)
    {
        if (($key = array_search($similarArtist, $this->similarArtists, true)) !== false) {
            unset($this->similarArtists[$key]);
            $this->similarArtists = array_values($this->similarArtists);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getApiData(): array
    {
        $genres = [];
        foreach ($this->getGenres() as $genre) {
            $genres[] = $genre->getApiData();
        }

        return [
            'name' => $this->getName(),
            'biography' => $this->getBiography(),
            'image' => $this->getImage(),
            'albumArt' => $this->getAlbumArt(),
            'playCount' => $this->getPlayCount(),
            'mbId' => $this->getMusicBrainzId(),
            'genres' => $genres,
        ];
    }
}
