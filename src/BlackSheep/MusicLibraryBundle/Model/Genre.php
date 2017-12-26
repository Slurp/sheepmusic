<?php

namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Traits\PlayCountTrait;

/**
 * Define a Genre.
 */
class Genre implements GenreInterface
{
    use PlayCountTrait;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $playCount;

    /**
     * @param $name
     *
     * @return GenreInterface
     */
    public static function createGenre($name)
    {
        $genre = new static();
        $genre->setName($name);

        return $genre;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getApiData()
    {
        return [
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
            'playCount' => $this->getPlayCount(),
        ];
    }
}
