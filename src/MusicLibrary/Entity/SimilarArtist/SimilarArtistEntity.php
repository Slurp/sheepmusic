<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity\SimilarArtist;

use BlackSheep\MusicLibrary\Entity\BaseEntity;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Model\SimilarArtist\SimilarArtists;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
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
     * @var
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibrary\Entity\ArtistsEntity")
     * @ORM\JoinColumn(name="similar_id", referencedColumnName="id")
     * @Assert\NotNull
     */
    protected $similar;
}
