<?php
namespace BlackSheep\MusicLibraryBundle\Events;

use BlackSheep\MusicLibraryBundle\Model\AlbumInterface;
use Symfony\Component\EventDispatcher\Event;

class AlbumEvent extends Event implements AlbumEventInterface
{
    /**
     * @var AlbumInterface
     */
    protected $album;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param AlbumInterface $album
     * @param null $value
     */
    public function __construct(AlbumInterface $album, $value = null)
    {
        $this->album = $album;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->album;
    }
}
