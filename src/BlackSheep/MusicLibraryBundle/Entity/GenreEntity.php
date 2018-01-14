<?php

namespace BlackSheep\MusicLibraryBundle\Entity;

use BlackSheep\MusicLibraryBundle\Model\Genre;
use BlackSheep\MusicLibraryBundle\Model\GenreInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(indexes={
 *     @ORM\Index(name="index_create", columns={"created_at"}),
 *     @ORM\Index(name="index_update", columns={"updated_at"})
 * }))
 * @ORM\Entity(repositoryClass="BlackSheep\MusicLibraryBundle\Repository\GenresRepository")
 */
class GenreEntity extends Genre implements GenreInterface
{
    use BaseEntity;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $playCount;

    /**
     * {@inheritdoc}
     */
    public function getApiData()
    {
        $array = parent::getApiData();
        $array['id'] = $this->getId();

        return $array;
    }
}
