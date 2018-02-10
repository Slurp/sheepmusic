<?php

namespace BlackSheep\MusicLibraryBundle\Entity\SimilarArtist;

use BlackSheep\MusicLibraryBundle\Entity\BaseEntity;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\SimilarArtist\SimilarArtists;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="artists_similar")
 */
class SimilarArtistEntity extends SimilarArtists
{
    use BaseEntity;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(0);
     */
    protected $match;

    /**
     * @var ArtistInterface
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity", inversedBy="similarArtists")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     * @Assert\NotNull
     */
    protected $artist;

    /**
     * @var $similar
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity")
     * @ORM\JoinColumn(name="similar_id", referencedColumnName="id")
     * @Assert\NotNull
     */
    protected $similar;
}
