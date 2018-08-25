<?php

namespace BlackSheep\MusicLibrary\Entity\SimilarArtist;

use BlackSheep\MusicLibrary\Entity\BaseEntity;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Model\SimilarArtist\SimilarArtists;
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
     * @var float
     * @ORM\Column(type="float", name="similar_match")
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(0);
     */
    protected $match;

    /**
     * @var ArtistInterface
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibrary\Entity\ArtistsEntity", inversedBy="similarArtists")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     * @Assert\NotNull
     */
    protected $artist;

    /**
     * @var $similar
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibrary\Entity\ArtistsEntity")
     * @ORM\JoinColumn(name="similar_id", referencedColumnName="id")
     * @Assert\NotNull
     */
    protected $similar;
}