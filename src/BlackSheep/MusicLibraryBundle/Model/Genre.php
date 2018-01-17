<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @var int
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
    public function getApiData(): array
    {
        return [
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
            'playCount' => $this->getPlayCount(),
        ];
    }
}
