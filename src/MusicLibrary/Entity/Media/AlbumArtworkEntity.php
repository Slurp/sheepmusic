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
use BlackSheep\MusicLibrary\Model\AlbumInterface;
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
class AlbumArtworkEntity extends AbstractArtworkEntity implements AlbumArtworkEntityInterface
{
    use BaseEntity;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="BlackSheep\MusicLibrary\Entity\AlbumEntity",
     *     inversedBy="artworks"
     * )
     *
     * @var AlbumInterface
     */
    protected $album;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(
     *     mapping="album_image",
     *     fileNameProperty="image.name",
     *     size="image.size",
     *     mimeType="image.mimeType",
     * originalName="image.originalName")
     *
     * @var File
     */
    protected $imageFile;

    /**
     * @return AlbumInterface
     */
    public function getAlbum(): AlbumInterface
    {
        return $this->album;
    }

    /**
     * @param AlbumInterface $album
     */
    public function setAlbum(?AlbumInterface $album)
    {
        $this->album = $album;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->getAlbum()->getSlug();
    }
}
