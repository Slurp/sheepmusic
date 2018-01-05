<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface GenreInterface.
 */
interface GenreInterface extends ApiInterface, PlayCountInterface
{
    /**
     * @param $name
     *
     * @return $this
     */
    public static function createGenre($name);

    /**
     * @return mixed
     */
    public function getSlug();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     *
     * @return GenreInterface
     */
    public function setName($name);
}
