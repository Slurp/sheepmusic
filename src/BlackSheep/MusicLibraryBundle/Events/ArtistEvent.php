<?php
namespace BlackSheep\MusicLibraryBundle\Events;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use Symfony\Component\EventDispatcher\Event;

class ArtistEvent extends Event implements ArtistEventInterface
{
    /**
     * @var ArtistInterface
     */
    protected $artist;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param ArtistInterface $artist
     * @param null $value
     */
    public function __construct(ArtistInterface $artist, $value = null)
    {
        $this->artist = $artist;
        $this->value = $value;
    }

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
    public function getValue()
    {
        return $this->artist;
    }
}
