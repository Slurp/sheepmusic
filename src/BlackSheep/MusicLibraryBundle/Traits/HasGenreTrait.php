<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 24/12/2017
 * Time: 01:22
 */
namespace BlackSheep\MusicLibraryBundle\Traits;

use BlackSheep\MusicLibraryBundle\Model\GenreInterface;

/**
 * Trait GenreCollectionTrait
 *
 * @package BlackSheep\MusicLibraryBundle\Traits
 */
trait HasGenreTrait
{
    /**
     * @var GenreInterface
     */
    protected $genre;

    /**
     * {@inheritdoc}
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * {@inheritdoc}
     */
    public function setGenre(GenreInterface $genre)
    {
        $this->genre = $genre;
    }
}
