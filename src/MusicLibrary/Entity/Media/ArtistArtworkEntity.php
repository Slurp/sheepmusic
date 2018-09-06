<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity\Media;

use BlackSheep\MusicLibrary\Entity\BaseEntity;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class ArtistArtworkEntity.
 *
 * @ORM\Table
 * @ORM\Entity
 * @Vich\Uploadable
 */
class ArtistArtworkEntity extends AbstractArtworkEntity implements ArtistArtworkEntityInterface
{
    use BaseEntity;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="BlackSheep\MusicLibrary\Entity\ArtistsEntity",
     *     inversedBy="artworks"
     * )
     */
    protected $artist;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(
     *     mapping="artist_image",
     *     fileNameProperty="image.name",
     *     size="image.size",
     *     mimeType="image.mimeType",
     *     originalName="image.originalName"
     * )
     *
     * @var File
     */
    protected $imageFile;

    /**
     * @return ArtistInterface
     */
    public function getArtist(): ArtistInterface
    {
        return $this->artist;
    }

    /**
     * @param ArtistInterface $artist
     */
    public function setArtist(ArtistInterface $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->getArtist()->getSlug();
    }
}
