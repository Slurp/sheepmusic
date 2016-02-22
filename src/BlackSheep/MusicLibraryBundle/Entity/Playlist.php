<?php
namespace BlackSheep\MusicLibraryBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Playlist extends BaseEntity
{

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Songs", mappedBy="playlist")
     */
    protected $songs;
}