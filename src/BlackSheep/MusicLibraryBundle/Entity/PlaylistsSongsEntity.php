<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\PlaylistsSongs;
use BlackSheep\MusicLibraryBundle\Model\SongInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class PlaylistsSongsEntity extends PlaylistsSongs
{
    use BaseEntity;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(0);
     */
    protected $position;

    /**
     * @var SongInterface
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibraryBundle\Entity\SongEntity")
     * @Assert\NotNull()
     */
    protected $song;

    /**
     * @var ResearchGroupInterface
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibraryBundle\Entity\PlaylistEntity", inversedBy="songs")
     * @ORM\JoinColumn(name="playlist_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    protected $playlist;
}
