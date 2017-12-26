<?php

namespace BlackSheep\MusicLibraryBundle\Model\Media;

use BlackSheep\MusicLibraryBundle\Entity\BaseEntity;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Class LogoEntity
 *
 * @package BlackSheep\MusicLibraryBundle\Entity\Media
 */
class Logo extends AbstractMedia implements LogoInterface
{
    use BaseEntity;

    /**
     * @var ArtistInterface
     */
    protected $artist;

    /**
     * @var int
     */
    protected $likes;

    /**
     * {@inheritdoc}
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * {@inheritdoc}
     */
    public function setArtist(ArtistInterface $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param mixed $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }
}
