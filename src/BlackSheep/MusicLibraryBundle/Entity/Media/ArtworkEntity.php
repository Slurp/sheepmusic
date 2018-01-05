<?php

namespace BlackSheep\MusicLibraryBundle\Entity\Media;

use BlackSheep\MusicLibraryBundle\Entity\BaseEntity;
use BlackSheep\MusicLibraryBundle\Model\Media\Artwork;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class ArtworkEntity.
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Vich\Uploadable
 */
class ArtworkEntity extends Artwork implements AbstractMediaInterface
{
    use BaseEntity;

    /**
     * @ORM\ManyToOne(targetEntity="BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity", inversedBy="artworks")
     */
    protected $artist;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $likes;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="artist_image", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName")
     *
     * @var File
     */
    protected $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    protected $image;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $type;

    /**
     * ArtworkEntity constructor.
     *
     * @param $type
     */
    public function __construct($type)
    {
        parent::__construct($type);
        $this->image = new EmbeddedFile();
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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param EmbeddedFile $image
     */
    public function setImage(EmbeddedFile $image)
    {
        $this->image = $image;
    }

    /**
     * @return EmbeddedFile
     */
    public function getImage()
    {
        return $this->image;
    }
}
